import csv
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas
from PIL import Image, ImageDraw, ImageFont
import os
import random

# Función para crear un PDF con el título del libro
def crear_pdf_titulo(titulo, archivo_pdf):
    c = canvas.Canvas(archivo_pdf, pagesize=letter)
    ancho, alto = letter
    c.setFont("Helvetica-Bold", 24)
    c.drawCentredString(ancho / 2, alto / 2, titulo)
    c.save()

# Función para crear una imagen con el título del libro
def crear_imagen_titulo(titulo, archivo_imagen):
    ancho, alto = 400, 500
    imagen = Image.new("RGB", (ancho, alto), color=(random.randint(200, 255), random.randint(200, 255), random.randint(200, 255)))
    draw = ImageDraw.Draw(imagen)
    
    try:
        fuente = ImageFont.truetype("arial.ttf", 40)
    except IOError:
        fuente = ImageFont.load_default()
    
    # Calcular el tamaño del texto con textbbox
    text_bbox = draw.textbbox((0, 0), titulo, font=fuente)
    text_ancho = text_bbox[2] - text_bbox[0]
    text_alto = text_bbox[3] - text_bbox[1]
    
    # Calcular posición centrada
    posicion = ((ancho - text_ancho) // 2, (alto - text_alto) // 2)
    
    # Dibujar el título
    draw.text(posicion, titulo, fill="black", font=fuente)
    imagen.save(archivo_imagen)

# Ruta del archivo CSV
csv_file = "books.csv"  # Cambia esto por la ruta a tu archivo CSV
output_folder = "output"  # Carpeta para guardar los PDFs e imágenes

# Crear carpeta de salida si no existe
os.makedirs(output_folder, exist_ok=True)

# Leer el archivo CSV y procesar los títulos
try:
    with open(csv_file, mode="r", encoding="utf-8") as file:
        csv_reader = csv.DictReader(file)
        for row in csv_reader:
            book_id = row["bookID"]  # Ajustar según el encabezado en el CSV
            titulo = row["title"]  # Ajustar según el encabezado en el CSV
            
            # Nombres de archivo usando el ID
            # archivo_pdf = os.path.join(output_folder, f"{book_id}.pdf")
            archivo_imagen = os.path.join(output_folder, f"{book_id}.png")
            
            # Generar PDF e imagen
            # crear_pdf_titulo(titulo, archivo_pdf)
            crear_imagen_titulo(titulo, archivo_imagen)
            
        print(f"Archivos generados en la carpeta '{output_folder}'")
except Exception as e:
    print(f"Error al procesar el archivo CSV: {e}")
