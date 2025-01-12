import pymysql
import csv
import os
import random
from datetime import datetime

# Datos de conexión
server = "localhost"
user = "root"
password = ""
database = "byteandbook"

# Rutas
csv_file = "books.csv"  # Cambia esto por la ruta a tu archivo CSV
output_folder = "output"  # Carpeta con los archivos PDF e imágenes

# Función de conexión a la base de datos
def conectar_base_de_datos():
    try:
        connection = pymysql.connect(
            host=server,
            user=user,
            password=password,
            database=database
        )
        print("Conexión exitosa a la base de datos.")
        return connection
    except Exception as e:
        print(f"Error al conectar a la base de datos: {e}")
        exit()

# Función para convertir fechas al formato correcto
def convertir_fecha(fecha):
    if fecha.endswith('.'):
        fecha = fecha[:-1]  # Eliminar punto final si existe
    formatos_validos = ["%m/%d/%Y", "%Y-%m-%d", "%d-%m-%Y", "%m/%d/%y"]  # Lista de formatos permitidos
    for formato in formatos_validos:
        try:
            return datetime.strptime(fecha, formato).strftime("%Y-%m-%d")
        except ValueError:
            continue
    print(f"Fecha inválida: {fecha} Se asignará NULL.")
    return None  # Si ningún formato es válido, devuelve None

# Función para cargar archivos como binarios
def cargar_archivo_binario(ruta):
    try:
        with open(ruta, "rb") as file:
            return file.read()
    except Exception as e:
        print(f"Error al leer el archivo {ruta}: {e}")
        return None


# Función para insertar datos en la tabla DATOS_LIBRO
def insertar_datos_libro(connection, row):
    insert_query = """
    INSERT INTO DATOS_LIBRO (ISBN, ID_GENERO, TITULO, EDITORIAL, EDICION, FECHA_PUBLICACION, IDIOMA, AUTORES, PAGINAS)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    try:
        isbn = row["isbn13"][:13]  # Ajustar al formato de ISBN de 13 caracteres
        id_genero = None  # Define cómo obtener este dato (puede requerir una consulta adicional)
        titulo = row["title"]
        editorial = row["publisher"]
        edicion = 1  # Valor predeterminado si no está en el CSV
        fecha_publicacion = convertir_fecha(row["publication_date"])
        idioma = row["language_code"]
        autores = row["authors"]
        paginas = int(row["num_pages"]) if row["num_pages"].isdigit() else None

        with connection.cursor() as cursor:
            cursor.execute(insert_query, (isbn, id_genero, titulo, editorial, edicion, fecha_publicacion, idioma, autores, paginas))
        connection.commit()
    except Exception as e:
        print(f"Error al insertar datos en DATOS_LIBRO: {e}")

# Función para insertar datos en la tabla VALORACIONES_LIBROS
def insertar_valoraciones_libros(connection, row):
    insert_valoracion_query = """
    INSERT INTO VALORACIONES_LIBROS (ID_DATOS_LIBRO, ID_USUARIO, VALORACION, COMENTARIO)
    VALUES (%s, %s, %s, %s)
    """
    try:
        valoracionesRandom = ["Muy buen libro", "Excelente libro", "Muy recomendado", "No me gustó", "Interesante", "Me encantó", "No lo recomiendo", "Regular", "Buen libro", "Me aburrió"]
        id_datos_libro = row["bookID"]  # Usamos el ID del libro como referencia
        id_datos_libro = int(id_datos_libro)
        valoracion = row["average_rating"]  # Valoración del libro
        valoracion = float(valoracion)
        id_usuario = id_datos_libro % 4 + 1  # ID de usuario (del 1 al 4)
        
        comentario = valoracionesRandom[random.randint(0, len(valoracionesRandom) - 1)]  # Comentario aleatorio

        if valoracion is not None:
            with connection.cursor() as cursor:
                cursor.execute(insert_valoracion_query, (id_datos_libro, id_usuario, valoracion, comentario))
            connection.commit()
    except Exception as e:
        print(f"Error al insertar valoraciones en VALORACIONES_LIBROS: {e}")

# Función para insertar datos en la tabla LIBRO_FISICO y LIBRO_VIRTUAL
def insertar_libros(connection, rows):
    insert_libro_fisico = """
    INSERT INTO LIBRO_FISICO (ID_DATOS_LIBRO, NUMERO_EJEMPLARES, DISPONIBILIDAD, PASILLO, ESTANTE)
    VALUES (%s, %s, %s, %s, %s)
    """
    insert_libro_virtual = """
    INSERT INTO LIBRO_VIRTUAL (ID_DATOS_LIBRO, RESUMEN, ARCHIVO, IMAGEN)
    VALUES (%s, %s, %s, %s)
    """
    try:
        with connection.cursor() as cursor:
            for idx, row in enumerate(rows):
                # Obtener datos básicos
                id_datos_libro = row["bookID"]  # Usamos el ID como referencia
                resumen = row["resumen"]
                num_ejemplares = int(row["ejemplares"]) if row["ejemplares"].isdigit() else 0
                disponibilidad = int(row["disponibilidad"]) if row["disponibilidad"].isdigit() else 0
                pasillo = int(row["pasillo"]) if row["pasillo"].isdigit() else 0
                estante = int(row["estante"]) if row["estante"].isdigit() else 0

                # Archivos asociados
                archivo_pdf = os.path.join(output_folder, f"{id_datos_libro}.pdf")
                archivo_png = os.path.join(output_folder, f"{id_datos_libro}.png")
                archivo_pdf_binario = cargar_archivo_binario(archivo_pdf)
                archivo_png_binario = cargar_archivo_binario(archivo_png)

                # Insertar en la tabla correspondiente
                if idx < 100:
                    # Insertar en LIBRO_FISICO
                    cursor.execute(
                        insert_libro_fisico,
                        (id_datos_libro, num_ejemplares, disponibilidad, pasillo, estante)
                    )
                else:
                    # Insertar en LIBRO_VIRTUAL
                    cursor.execute(
                        insert_libro_virtual,
                        (id_datos_libro, resumen, archivo_pdf_binario, archivo_png_binario)
                    )
            connection.commit()
    except Exception as e:
        print(f"Error al insertar en LIBRO_FISICO o LIBRO_VIRTUAL: {e}")

# Función principal para leer el archivo CSV y procesar los datos
def procesar_csv():
    connection = conectar_base_de_datos()
    
    try:
        with open(csv_file, mode="r", encoding="utf-8") as file:
            csv_reader = csv.DictReader(file)
            rows = list(csv_reader)  # Convertir el lector a una lista para iterar fácilmente

            # Insertar datos en la tabla DATOS_LIBRO
            for row in rows:
                insertar_datos_libro(connection, row)

            # Insertar valoraciones en la tabla VALORACIONES_LIBROS
            for row in rows:
                insertar_valoraciones_libros(connection, row)

            # Insertar en LIBRO_FISICO y LIBRO_VIRTUAL
            insertar_libros(connection, rows)
            
        print("Datos insertados exitosamente en las tablas.")
    
    except Exception as e:
        print(f"Error al procesar el archivo CSV: {e}")
    
    finally:
        connection.close()
        print("Conexión cerrada.")

# Ejecutar el procesamiento del archivo CSV
if __name__ == "__main__":
    procesar_csv()
