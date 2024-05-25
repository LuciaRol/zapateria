CREATE DATABASE IF NOT EXISTS agenda_recuperacion;
SET NAMES UTF8;
USE agenda_recuperacion;

DROP TABLE IF EXISTS contactos;
CREATE TABLE IF NOT EXISTS contactos( 
id              int auto_increment not null,
nombre          varchar(64) not null,
apellidos       varchar(64) not null,
correo          varchar(255) not null,
direccion       varchar(255) not null,
telefono        varchar(9) not null,
fecha_nacimiento date default null,
CONSTRAINT pk_contactos PRIMARY KEY(id),
UNIQUE KEY telefono_UNIQUE (telefono),
UNIQUE KEY correo_UNIQUE  (correo)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO contactos VALUES(null,"Marta","Martos Portellano","marta@marta.es","c/Jacinto, 5 Granada", "958123456",'1999-01-23');
INSERT INTO contactos VALUES(null,"Pedro","Moreno Prieto","pedro@pedro.es","c/Amapola, 3 Granada", "958673454",'1970-05-12');

DROP TABLE IF EXISTS reuniones;
CREATE TABLE IF NOT EXISTS reuniones( 
id              int auto_increment not null,
Fechahora       datetime not null,
lugar           varchar(255) not null,
contacto_id     int not null,
CONSTRAINT pk_reuniones PRIMARY KEY(id),
CONSTRAINT fk_cita_contacto FOREIGN KEY(contacto_id) REFERENCES contactos(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO reuniones VALUES(null,'2022-01-23 12:45:56',"sala Alhambra","1");
INSERT INTO reuniones VALUES(null,'2022-03-12 10:05:13',"sala Los cerezos","2");