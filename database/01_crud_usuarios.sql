-- ============================================================
-- CRUD Usuarios - Script de base de datos (MySQL / MariaDB)
-- Crea el usuario de BD, la base de datos, la tabla users
-- y el usuario administrador base.
-- ============================================================

-- 1. Usuario de base de datos
CREATE USER IF NOT EXISTS 'Estudiante'@'%' IDENTIFIED BY 'Developer';
CREATE USER IF NOT EXISTS 'Estudiante'@'localhost' IDENTIFIED BY 'Developer';

-- 2. Base de datos
DROP DATABASE IF EXISTS crud_usuarios;
CREATE DATABASE crud_usuarios CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 3. Permisos
GRANT ALL PRIVILEGES ON crud_usuarios.* TO 'Estudiante'@'%';
GRANT ALL PRIVILEGES ON crud_usuarios.* TO 'Estudiante'@'localhost';
FLUSH PRIVILEGES;

USE crud_usuarios;

-- 4. Tabla de usuarios
-- El id es un UUID generado por la aplicacion (public/index.php).
-- El password se guarda como hash bcrypt (UserPassword::fromPlainText).
CREATE TABLE users (
    id          VARCHAR(36)  NOT NULL PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        VARCHAR(20)  NOT NULL DEFAULT 'MEMBER',
    status      VARCHAR(20)  NOT NULL DEFAULT 'PENDING',
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. Usuario administrador base (clave: admin123)
INSERT INTO users (id, name, email, password, role, status)
VALUES (
    '00000000-0000-4000-8000-000000000001',
    'Administrador',
    'admin@crud.com',
    '$2y$10$2knJYjgqG38V2beCFNR/WuyxZ.8MP3wK7fOF6G9PWgzFnc4UNgq2C',
    'ADMIN',
    'ACTIVE'
);

-- 6. Verificacion
SELECT id, name, email, role, status FROM users;
