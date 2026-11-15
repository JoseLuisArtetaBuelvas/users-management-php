-- ============================================================
-- Ejercicio 2: Universidad (MySQL / MariaDB local)
-- Ejecutar despues de 01_crud_usuarios.sql
-- ============================================================

USE crud_usuarios;

DROP TABLE IF EXISTS universidades;

CREATE TABLE universidades (
    id               VARCHAR(36)        NOT NULL PRIMARY KEY,
    nombre           VARCHAR(120)       NOT NULL UNIQUE,
    categoria        VARCHAR(20)        NOT NULL,
    web              VARCHAR(255)       NOT NULL,
    rector           VARCHAR(100)       NOT NULL,
    email            VARCHAR(150)       NOT NULL UNIQUE,
    acceso           VARCHAR(30)        NOT NULL,
    telefono         VARCHAR(25)        NOT NULL,
    ciudad           VARCHAR(60)        NOT NULL,
    numero_carreras  SMALLINT UNSIGNED  NOT NULL,
    num_sedes        SMALLINT UNSIGNED  NOT NULL,
    created_at       DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT chk_universidades_categoria CHECK (categoria IN ('PUBLICA', 'PRIVADA')),
    CONSTRAINT chk_universidades_acceso CHECK (acceso IN ('EXAMEN_ADMISION', 'PRUEBAS_SABER_11', 'INGRESO_DIRECTO', 'MIXTO')),
    CONSTRAINT chk_universidades_carreras CHECK (numero_carreras BETWEEN 1 AND 500),
    CONSTRAINT chk_universidades_sedes CHECK (num_sedes BETWEEN 1 AND 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de ejemplo
INSERT INTO universidades (id, nombre, categoria, web, rector, email, acceso, telefono, ciudad, numero_carreras, num_sedes)
VALUES
    ('9a3e5b10-2c4d-4e6f-8a00-000000000001', 'Universidad de Cartagena', 'PUBLICA', 'https://www.unicartagena.edu.co',
     'María Fernanda Ríos', 'rectoria@unicartagena.edu.co', 'PRUEBAS_SABER_11', '+57 605 600 1234',
     'Cartagena', 42, 5),
    ('9a3e5b10-2c4d-4e6f-8a00-000000000002', 'Universidad Tecnológica de Bolívar', 'PRIVADA', 'https://www.utb.edu.co',
     'Carlos Andrés Mejía', 'contacto@utb.edu.co', 'MIXTO', '+57 605 600 5678',
     'Cartagena', 25, 1);

SELECT id, nombre, categoria, ciudad, numero_carreras, num_sedes FROM universidades;