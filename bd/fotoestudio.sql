CREATE DATABASE fotoestudio;
USE fotoestudio;

CREATE TABLE usuario (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(80) NOT NULL,
	direccion VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	clave VARCHAR(500) NOT NULL,
	privilegio VARCHAR(15) NOT NULL,
	foto VARCHAR(100) NOT NULL
);

CREATE TABLE evento (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(80) NOT NULL,
	carpeta VARCHAR(80) NOT NULL,
	direccion VARCHAR(100) NOT NULL,
	coordenada_x DOUBLE NOT NULL,
	coordenada_y DOUBLE NOT NULL,
	fecha DATETIME NOT NULL
);

CREATE TABLE foto (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ruta VARCHAR(200) NOT NULL,
	id_evento INT NOT NULL,
	FOREIGN KEY(id_evento) REFERENCES evento(id)
);

CREATE TABLE foto_marca (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ruta VARCHAR(200) NOT NULL,
	id_foto INT NOT NULL,
	FOREIGN KEY(id_foto) REFERENCES foto(id)
);

CREATE TABLE foto_usuario (
	id INT NOT NULL,
	id_usuario INT NOT NULL,
	id_foto INT NOT NULL,
	FOREIGN KEY(id_usuario) REFERENCES usuario(id),
	FOREIGN KEY(id_foto) REFERENCES foto(id)
);