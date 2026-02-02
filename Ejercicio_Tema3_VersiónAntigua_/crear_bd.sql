-- Script SQL para crear la base de datos y tabla del ejercicio G
-- Ejecutar en PHPMyAdmin o desde la terminal de MySQL

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS ejercicios
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;

-- Usar la base de datos
USE ejercicios;

-- Crear la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Verificar que la tabla se creó correctamente
DESCRIBE usuarios;
