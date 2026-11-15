-- ============================================================
-- CRUD Usuarios - Script para PostgreSQL (Supabase)
-- Ejecutar en Supabase: SQL Editor -> New query -> Run
-- Supabase ya trae la base de datos "postgres", no se crea otra.
-- ============================================================

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id          VARCHAR(36)  PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        VARCHAR(20)  NOT NULL DEFAULT 'MEMBER',
    status      VARCHAR(20)  NOT NULL DEFAULT 'PENDING',
    created_at  TIMESTAMP    NOT NULL DEFAULT NOW(),
    updated_at  TIMESTAMP    NOT NULL DEFAULT NOW()
);

-- Supabase publica las tablas de "public" en su API REST. Con RLS activo y sin
-- politicas, la API no puede leerlas; la app conecta como propietaria (postgres)
-- y no se ve afectada.
ALTER TABLE users ENABLE ROW LEVEL SECURITY;

-- Usuario administrador base (clave: admin123, hash bcrypt)
INSERT INTO users (id, name, email, password, role, status)
VALUES (
    '00000000-0000-4000-8000-000000000001',
    'Administrador',
    'admin@crud.com',
    '$2y$10$2knJYjgqG38V2beCFNR/WuyxZ.8MP3wK7fOF6G9PWgzFnc4UNgq2C',
    'ADMIN',
    'ACTIVE'
);

SELECT id, name, email, role, status FROM users;
