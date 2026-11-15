-- ============================================================
-- Ejercicio 3: Docente
-- Ejecutar despues de 01_crud_usuarios.sql
-- ============================================================

USE crud_usuarios;

DROP TABLE IF EXISTS docentes;

CREATE TABLE docentes (
    id                 VARCHAR(36)       NOT NULL PRIMARY KEY,
    nombre             VARCHAR(100)      NOT NULL,
    apellidos          VARCHAR(100)      NOT NULL,
    email              VARCHAR(150)      NOT NULL UNIQUE,
    telefono           VARCHAR(25)       NOT NULL,
    blog               VARCHAR(255)      NULL,
    profesional        VARCHAR(150)      NOT NULL,
    escalafon          VARCHAR(20)       NOT NULL,
    idioma             VARCHAR(20)       NOT NULL,
    anios_experiencia  TINYINT UNSIGNED  NOT NULL DEFAULT 0,
    area_trabajo       VARCHAR(150)      NOT NULL,
    created_at         DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at         DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_docentes_escalafon CHECK (escalafon IN ('AUXILIAR', 'ASISTENTE', 'ASOCIADO', 'TITULAR')),
    CONSTRAINT chk_docentes_idioma CHECK (idioma IN ('ESPANOL', 'INGLES', 'FRANCES', 'PORTUGUES', 'ALEMAN', 'OTRO')),
    CONSTRAINT chk_docentes_anios CHECK (anios_experiencia BETWEEN 0 AND 60)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de ejemplo
INSERT INTO docentes (id, nombre, apellidos, email, telefono, blog, profesional, escalafon, idioma, anios_experiencia, area_trabajo)
VALUES
    ('7f1c2a8e-1b3d-4c5e-9f00-000000000001', 'Carlos', 'Mendoza Ríos', 'carlos.mendoza@unicartagena.edu.co',
     '+57 300 111 2233', 'https://carlosmendoza.dev', 'Magíster en Ingeniería de Software',
     'ASOCIADO', 'ESPANOL', 12, 'Ingeniería de software'),
    ('7f1c2a8e-1b3d-4c5e-9f00-000000000002', 'Laura', 'Gómez Pérez', 'laura.gomez@unicartagena.edu.co',
     '3104445566', NULL, 'Ingeniera de Sistemas',
     'AUXILIAR', 'INGLES', 3, 'Bases de datos');

SELECT id, nombre, apellidos, email, escalafon, idioma, anios_experiencia FROM docentes;
