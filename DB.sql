

CREATE TABLE DATOS_PERSONALES (
	ID_DATOS_PERSONALES INT PRIMARY KEY AUTO_INCREMENT,
	NOMBRE VARCHAR(100),
	APELLIDO_1 VARCHAR(100),
	APELLIDO_2 VARCHAR(100),
	TELEFONO VARCHAR(10)
);

CREATE TABLE DIRECCIONES(
	ID_DIRECCION INT PRIMARY KEY AUTO_INCREMENT,
	CALLE VARCHAR(100),
	NUMERO_EXT INT,
	NUMERO_INT VARCHAR(15),
	COLONIA VARCHAR(100),
	ALCALDIA VARCHAR(100),
	CODIGO_POSTAL VARCHAR(5)
);

CREATE TABLE USUARIOS (
	ID_USUARIO INT PRIMARY KEY AUTO_INCREMENT,
	ID_DATOS_PERSONALES INT,
	ID_DIRECCION INT,
	FECHA_NACIMIENTO DATE,
	CORREO VARCHAR(100) UNIQUE,
	CONTRASENA VARCHAR(100),
	TIPO_USUARIO INT,
	FOREIGN KEY (ID_DATOS_PERSONALES) REFERENCES DATOS_PERSONALES(ID_DATOS_PERSONALES),
	FOREIGN KEY (ID_DIRECCION) REFERENCES DIRECCIONES(ID_DIRECCION)
);

CREATE TABLE CATALOGO_GENEROS(
	ID_GENERO INT PRIMARY KEY AUTO_INCREMENT,
	NOMBRE_GENERO VARCHAR(100)
);

CREATE TABLE DATOS_LIBRO(
	ID_DATOS_LIBRO INT PRIMARY KEY AUTO_INCREMENT,
	ID_GENERO INT,
	TITULO VARCHAR(100),
	EDITORIAL VARCHAR(100),
	EDICION INT,
	
	FOREIGN KEY (ID_GENERO) REFERENCES CATALOGO_GENEROS(ID_GENERO)
);

CREATE TABLE LIBROS_AUTORES(
	ID_LIBRO_AUTOR INT PRIMARY KEY AUTO_INCREMENT,
	ID_DATOS_LIBRO INT,
	ID_DATOS_PERSONALES INT,
	FOREIGN KEY (ID_DATOS_LIBRO) REFERENCES DATOS_LIBRO(ID_DATOS_LIBRO),
	FOREIGN KEY (ID_DATOS_PERSONALES) REFERENCES DATOS_PERSONALES(ID_DATOS_PERSONALES)
);

CREATE TABLE LIBRO_FISICO(
	ID_LIBRO_FISICO INT PRIMARY KEY AUTO_INCREMENT,
	ID_DATOS_LIBRO INT,
	NUMERO_EJEMPLARES INT,
	DISPONIBILIDAD INT,
	PASILLO INT,
	ESTANTE INT,
	FOREIGN KEY (ID_DATOS_LIBRO) REFERENCES DATOS_LIBRO(ID_DATOS_LIBRO)
);

CREATE TABLE LIBRO_VIRTUAL(
	ID_LIBRO_VIRTUAL INT PRIMARY KEY AUTO_INCREMENT,
	ID_DATOS_LIBRO INT,
	LINK_ARCHIVO VARCHAR(500),
	RESUMEN VARCHAR(500),
	FOREIGN KEY (ID_DATOS_LIBRO) REFERENCES DATOS_LIBRO(ID_DATOS_LIBRO)
);

CREATE TABLE VALORACIONES_LIBROS(
	ID_VALORACION INT PRIMARY KEY AUTO_INCREMENT,
	ID_DATOS_LIBRO INT,
	ID_USUARIO INT,
	VALORACION INT,
	COMENTARIO VARCHAR(500),
	FOREIGN KEY (ID_DATOS_LIBRO) REFERENCES DATOS_LIBRO(ID_DATOS_LIBRO),
	FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS(ID_USUARIO)
);

CREATE TABLE PRESTAMOS(
	ID_PRESTAMO INT PRIMARY KEY AUTO_INCREMENT,
	ID_LIBRO_FISICO INT,
	ID_USUARIO INT,
	FECHA_PRESTAMO DATE,
	FECHA_ENTREGA DATE,
	ESTADO INT,
	FOREIGN KEY (ID_LIBRO_FISICO) REFERENCES LIBRO_FISICO(ID_LIBRO_FISICO),
	FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS(ID_USUARIO)
);

CREATE TABLE TARJETAS(
	ID_TARJETA INT PRIMARY KEY AUTO_INCREMENT,
	ID_USUARIO INT,
	NUMERO_TARJETA VARCHAR(16),
	FECHA_VENCIMIENTO DATE,
	CVV VARCHAR(3),
	FOREIGN KEY (ID_USUARIO) REFERENCES USUARIOS(ID_USUARIO)
);


DELIMITER //

CREATE PROCEDURE RegistrarUsuario(
	IN p_nombre VARCHAR(100),
	IN p_apellido1 VARCHAR(100),
	IN p_apellido2 VARCHAR(100),
	IN p_telefono VARCHAR(10),
	IN p_calle VARCHAR(100),
	IN p_numero_ext INT,
	IN p_numero_int VARCHAR(15),
	IN p_colonia VARCHAR(100),
	IN p_alcaldia VARCHAR(100),
	IN p_codigo_postal VARCHAR(5),
	IN p_fecha_nacimiento DATE,
	IN p_correo VARCHAR(100),
	IN p_contrasena VARCHAR(100),
	IN p_tipo_usuario INT
)
BEGIN
	DECLARE v_id_datos_personales INT;
	DECLARE v_id_direccion INT;

	INSERT INTO DATOS_PERSONALES (NOMBRE, APELLIDO_1, APELLIDO_2, TELEFONO)
	VALUES (p_nombre, p_apellido1, p_apellido2, p_telefono);
	SET v_id_datos_personales = LAST_INSERT_ID();

	INSERT INTO DIRECCIONES (CALLE, NUMERO_EXT, NUMERO_INT, COLONIA, ALCALDIA, CODIGO_POSTAL)
	VALUES (p_calle, p_numero_ext, IFNULL(p_numero_int, NULL), p_colonia, p_alcaldia, p_codigo_postal);
	SET v_id_direccion = LAST_INSERT_ID();

	INSERT INTO USUARIOS (ID_DATOS_PERSONALES, ID_DIRECCION, FECHA_NACIMIENTO, CORREO, CONTRASENA, TIPO_USUARIO)
	VALUES (v_id_datos_personales, v_id_direccion, p_fecha_nacimiento, p_correo, p_contrasena, p_tipo_usuario);
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE ActualizarDatosUsuario(
	IN p_id_usuario INT,
	IN p_nombre VARCHAR(100),
	IN p_apellido1 VARCHAR(100),
	IN p_apellido2 VARCHAR(100),
	IN p_telefono VARCHAR(10),
	IN p_calle VARCHAR(100),
	IN p_numero_ext INT,
	IN p_numero_int VARCHAR(15),
	IN p_colonia VARCHAR(100),
	IN p_alcaldia VARCHAR(100),
	IN p_codigo_postal VARCHAR(5),
	IN p_fecha_nacimiento DATE,
	IN p_correo VARCHAR(100),
	IN p_contrasena VARCHAR(100),
	IN p_tipo_usuario INT
)
BEGIN
	DECLARE v_id_datos_personales INT;
	DECLARE v_id_direccion INT;

	SELECT ID_DATOS_PERSONALES, ID_DIRECCION INTO v_id_datos_personales, v_id_direccion
	FROM USUARIOS
	WHERE ID_USUARIO = p_id_usuario;

	UPDATE DATOS_PERSONALES
	SET NOMBRE = p_nombre, APELLIDO_1 = p_apellido1, APELLIDO_2 = p_apellido2, TELEFONO = p_telefono
	WHERE ID_DATOS_PERSONALES = v_id_datos_personales;

	UPDATE DIRECCIONES
	SET CALLE = p_calle, NUMERO_EXT = p_numero_ext, NUMERO_INT = p_numero_int, COLONIA = p_colonia, ALCALDIA = p_alcaldia, CODIGO_POSTAL = p_codigo_postal
	WHERE ID_DIRECCION = v_id_direccion;

	UPDATE USUARIOS
	SET FECHA_NACIMIENTO = p_fecha_nacimiento, CORREO = p_correo, CONTRASENA = p_contrasena, TIPO_USUARIO = p_tipo_usuario
	WHERE ID_USUARIO = p_id_usuario;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE ObtenerDatosUsuario(
	IN p_correo VARCHAR(100),
	IN p_contrasena VARCHAR(100)
)
BEGIN
	SELECT u.ID_USUARIO, dp.NOMBRE, dp.APELLIDO_1, dp.APELLIDO_2, dp.TELEFONO, 
		   d.CALLE, d.NUMERO_EXT, d.NUMERO_INT, d.COLONIA, d.ALCALDIA, d.CODIGO_POSTAL, 
		   u.FECHA_NACIMIENTO, u.CORREO, u.TIPO_USUARIO
	FROM USUARIOS u
	JOIN DATOS_PERSONALES dp ON u.ID_DATOS_PERSONALES = dp.ID_DATOS_PERSONALES
	JOIN DIRECCIONES d ON u.ID_DIRECCION = d.ID_DIRECCION
	WHERE u.CORREO = p_correo AND u.CONTRASENA = p_contrasena;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE ObtenerContrasena(
	IN p_correo VARCHAR(100)
)
BEGIN
	SELECT CONTRASENA
	FROM USUARIOS
	WHERE CORREO = p_correo;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE RegistrarPrestamo(
    IN p_id_libro_fisico INT,
    IN p_id_usuario INT,
    IN p_fecha_prestamo DATE,
    IN p_fecha_entrega DATE,
    IN p_estado INT
)
BEGIN
    -- Inserta en la tabla PRESTAMOS
    INSERT INTO PRESTAMOS (ID_LIBRO_FISICO, ID_USUARIO, FECHA_PRESTAMO, FECHA_ENTREGA, ESTADO)
    VALUES (p_id_libro_fisico, p_id_usuario, p_fecha_prestamo, p_fecha_entrega, p_estado);

    -- Actualiza el número de libros disponibles en la tabla LIBROS
    UPDATE LIBRO_FISICO
    SET DISPONIBILIDAD = DISPONIBILIDAD - 1
    WHERE ID_LIBRO = p_id_libro_fisico;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE ActualizarPrestamo(
	IN p_id_prestamo INT,
	IN p_id_libro_fisico INT,
	IN p_id_usuario INT,
	IN p_fecha_prestamo DATE,
	IN p_fecha_entrega DATE,
	IN p_estado INT
)
BEGIN
	UPDATE PRESTAMOS
	SET ID_LIBRO_FISICO = p_id_libro_fisico, ID_USUARIO = p_id_usuario, FECHA_PRESTAMO = p_fecha_prestamo, FECHA_ENTREGA = p_fecha_entrega, ESTADO = p_estado
	WHERE ID_PRESTAMO = p_id_prestamo;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerPrestamosUsuario(
	IN p_id_usuario INT
)
BEGIN
	SELECT p.ID_PRESTAMO, p.ID_LIBRO_FISICO, p.FECHA_PRESTAMO, p.FECHA_ENTREGA, p.ESTADO
	FROM PRESTAMOS p
	WHERE p.ID_USUARIO = p_id_usuario;
END //

DELIMITER ;

DELIMITER //
CREATE PROCEDURE ObtenerDisponibilidadLibro(
	IN p_id_libro INT
)
BEGIN
	SELECT DISPONIBILIDAD
	FROM LIBRO_FISICO
	WHERE ID_LIBRO_FISICO = p_id_libro;
END //

DELIMITER ;


insert into datos_personales (NOMBRE, APELLIDO_1, APELLIDO_2, TELEFONO) values 
('Juan', 'Perez', 'Gomez', '5512345678'),
('Maria', 'Gonzalez', 'Lopez', '5512345678'),
('Pedro', 'Ramirez', 'Garcia', '5512345678'),
('Ana', 'Hernandez', 'Martinez', '5512345678'),
('Luis', 'Torres', 'Rodriguez', '5512345678'),
('Sofia', 'Sanchez', 'Perez', '5512345678'),
('Carlos', 'Gomez', 'Garcia', '5512345678'),
('Fernanda', 'Martinez', 'Lopez', '5512345678'),
('Jorge', 'Lopez', 'Gomez', '5512345678'),
('Diana', 'Garcia', 'Hernandez', '5512345678'),
('Jose', 'Martinez', 'Sanchez', '5512345678'),
('Julian', 'Rodriguez', 'Torres', '5512345678');

insert into direcciones (CALLE, NUMERO_EXT, NUMERO_INT, COLONIA, ALCALDIA, CODIGO_POSTAL) values 
('Calle 1', 123, 'A', 'Colonia 1', 'Alcaldia 1', '12345'),
('Calle 2', 123, 'B', 'Colonia 2', 'Alcaldia 2', '12345'),
('Calle 3', 123, 'C', 'Colonia 3', 'Alcaldia 3', '12345'),
('Calle 4', 123, 'D', 'Colonia 4', 'Alcaldia 4', '12345'),
('Calle 5', 123, 'E', 'Colonia 5', 'Alcaldia 5', '12345'),
('Calle 6', 123, 'F', 'Colonia 6', 'Alcaldia 6', '12345'),
('Calle 7', 123, 'G', 'Colonia 7', 'Alcaldia 7', '12345'),
('Calle 8', 123, 'H', 'Colonia 8', 'Alcaldia 8', '12345'),
('Calle 9', 123, 'I', 'Colonia 9', 'Alcaldia 9', '12345'),
('Calle 10', 123, 'J', 'Colonia 10', 'Alcaldia 10', '12345'),
('Calle 11', 123, 'K', 'Colonia 11', 'Alcaldia 11', '12345'),
('Calle 12', 123, 'L', 'Colonia 12', 'Alcaldia 12', '12345');

insert into usuarios (ID_DATOS_PERSONALES, ID_DIRECCION, FECHA_NACIMIENTO, CORREO, CONTRASENA, TIPO_USUARIO) values 
(1, 1, '1990-01-01', 'juan@mail.com', '123456', 1),
(2, 2, '1990-01-01', 'maria@mail.com', '123456', 1),
(3, 3, '1990-01-01', 'pedro@mail.com', '123456', 1),
(4, 4, '1990-01-01', 'ana@mail.com', '123456', 1),
(5, 5, '1990-01-01', 'luis@mail.com', '123456', 1),
(6, 6, '1990-01-01', 'sofia@mail.com', '123456', 1),
(7, 7, '1990-01-01', 'carlos@mail.com', '123456', 1),
(8, 8, '1990-01-01', 'fernanda@mail.com', '123456', 1),
(9, 9, '1990-01-01', 'jorge@mail.com', '123456', 1),
(10, 10, '1990-01-01', 'diana@mail.com', '123456', 1),
(11, 11, '1990-01-01', 'jose@mail.com',123456,2),
(12, 12, '1990-01-01', 'julian@mail.com',123456,3);

insert into catalogo_generos (NOMBRE_GENERO) values 
('Accion'),
('Aventura'),
('Comedia'),
('Drama'),
('Fantasia'),
('Historia'),
('Horror'),
('Misterio'),
('Romance'),
('Suspenso');



