CREATE DATABASE IF NOT EXISTS ud2_talleres CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ud2_talleres;

CREATE TABLE IF NOT EXISTS taller (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL UNIQUE,
    plazas INT NOT NULL
);

CREATE TABLE IF NOT EXISTS inscripcion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    taller_id INT NOT NULL,
    nombre VARCHAR(80) NOT NULL,
    email VARCHAR(160) NOT NULL,
    estado VARCHAR(12) NOT NULL,
    FOREIGN KEY (taller_id) REFERENCES taller(id),
    UNIQUE (taller_id, email)
);

INSERT INTO taller (titulo, plazas) VALUES
    ('Introducción a la fotografía', 2),
    ('Edición de sonido', 3);
