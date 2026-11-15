# CRUD Usuarios: Arquitectura Hexagonal con DDD y CQRS

Aplicación web PHP para la gestión de usuarios: registro, listado, visualización, edición, eliminación, autenticación con sesión y recuperación de contraseña por correo.

## Tecnologías

- PHP 8.3
- MySQL
- Apache mod_rewrite

---

## Funcionalidades

- Crear, listar, ver, editar y eliminar usuarios
- Autenticación con sesión (login / logout)
- Recuperación de contraseña mediante contraseña temporal enviada por correo
- Protección de rutas según estado de autenticación
- Protección contra acceso directo a archivos y listado de directorios
- Envía notificaciones a los usuarios vía Correo Electronico

---

## Conceptos aplicados

### Arquitectura general
- Arquitectura Hexagonal (Ports & Adapters)
- DDD (Domain-Driven Design)
- CQRS
- Capas: Domain / Application / Infrastructure / Entrypoints
- Front Controller · Single Entry Point

### Capa de Dominio
- Rich Domain Model
- Value Objects
- Named Constructors
- Domain Exceptions
- Domain Events
- Enumerations (Enums)
- Ubiquitous Language
- Inmutabilidad
- Fail-fast validation
- Encapsulación de reglas de negocio


### Capa de Aplicación
- Use Cases
- Application Services
- Ports In (interfaces de casos de uso)
- Ports Out (interfaces de persistencia)
- Commands y Queries
- DTOs
- Anti-corruption Layer
- Application Mapper


### Capa de Infraestructura
- Repository Pattern
- Data Mapper
- Persistence DTO
- Persistence Entity
- PDO con Prepared Statements
- Adapter Pattern

### Entrypoints / Presentación
- Enrutamiento por query string (`?route=`)
- PRG (Post-Redirect-Get)
- Flash Messages
- Autenticación basada en sesiones
- Web Mapper
- Web DTOs (WebRequest / UserResponse)
- `View::render` con `extract`
- Security Guard (IIFE)

---

### Patrones de diseño
- Front Controller
- Repository
- Data Mapper
- Factory Method
- DTO
- Strategy
- Template Method
- IIFE
- PRG (Post-Redirect-Get)

### Principios SOLID
- **SRP** — Single Responsibility Principle
- **OCP** — Open/Closed Principle
- **LSP** — Liskov Substitution Principle
- **ISP** — Interface Segregation Principle
- **DIP** — Dependency Inversion Principle

### Principios de Clean Code
- `declare(strict_types=1)` en todos los archivos
- Clases `final`
- Value Objects inmutables
- Named Constructors
- Fail-fast
- Nombres autodocumentados
- Separación estricta de capas
- Sin fugas de abstracción
- Fail-safe defaults (valores por defecto seguros)

### Configuración externalizada (12-Factor App: Factor III)
- Variables de entorno separadas del código fuente
- Credenciales en `.env` (ignorado por git), nunca en se debe publicar en el repo
- `.env.example` como plantilla y documentación de ejemplo para el equipo
- `EnvLoader` con responsabilidad única: leer el entorno
- Las variables reales del servidor tienen prioridad sobre `.env` (environment-over-code)

### Seguridad

- Credenciales fuera del código fuente y del historial de git



---

## Ejercicio 3: CRUDL de Docente

Además de la entidad común **Usuario**, el proyecto implementa el CRUDL de la entidad **Docente** respetando las mismas capas.

**Estudiante:** José Luis Arteta Buelvas

### Atributos y reglas de negocio

| Atributo | Regla (Value Object / Enum) |
|---|---|
| id | UUID v4 generado por la aplicación (`DocenteId`) |
| nombre, apellidos | Obligatorios, 2 a 100 caracteres, solo letras y espacios (`DocenteNombre`) |
| email | Formato válido, se guarda en minúsculas y no se repite (`DocenteEmail`) |
| telefono | 7 a 15 dígitos; admite `+`, espacios y guiones (`DocenteTelefono`) |
| blog | Opcional; si se informa debe ser URL `http(s)` (`DocenteBlog`) |
| profesional | Título profesional, 3 a 150 caracteres (`DocenteCampoTexto`) |
| escalafon | `AUXILIAR`, `ASISTENTE`, `ASOCIADO`, `TITULAR` (`DocenteEscalafonEnum`) |
| idioma | `ESPANOL`, `INGLES`, `FRANCES`, `PORTUGUES`, `ALEMAN`, `OTRO` (`DocenteIdiomaEnum`) |
| aniosExperiencia | Entero entre 0 y 60 (`DocenteAniosExperiencia`) |
| areaTrabajo | 3 a 150 caracteres (`DocenteCampoTexto`) |

Regla adicional del modelo: un docente con 10 o más años de experiencia es **experimentado** (`DocenteModel::esExperimentado()`).

### Archivos por capa

| Capa | Elementos |
|---|---|
| Dominio | `DocenteModel`, 7 Value Objects, 2 Enums, 11 excepciones, 3 eventos (`docente.created/updated/deleted`) |
| Aplicación | 6 puertos de salida, 5 casos de uso (puertos de entrada), 3 commands, 2 queries, `DocenteApplicationMapper`, 5 servicios |
| Infraestructura (adaptador) | `DocentePersistenceDto`, `DocenteEntity`, `DocentePersistenceMapper`, `DocenteRepositoryMySQL` |
| Infraestructura (entrypoint) | `CreateDocenteWebRequest`, `UpdateDocenteWebRequest`, `DocenteResponse`, `DocenteWebMapper`, `DocenteController`, rutas `docentes.*` y vistas `Views/docentes` |
| Común | Registro en `ClassLoader` e inyección en `DependencyInjection` |

### Flujo de una operación (crear docente)

```
Formulario HTML -> public/index.php (docentes.store) -> CreateDocenteWebRequest
  -> DocenteWebMapper -> CreateDocenteCommand -> CreateDocenteService (CreateDocenteUseCase)
  -> DocenteApplicationMapper -> DocenteModel (Value Objects validan)
  -> SaveDocentePort -> DocenteRepositoryMySQL -> tabla docentes
```

### Rutas

| Ruta | Método | Operación |
|---|---|---|
| `?route=docentes.index&q=texto` | GET | Listar y buscar (L) |
| `?route=docentes.create` / `docentes.store` | GET / POST | Registrar (C) |
| `?route=docentes.show&id=...` | GET | Consultar (R) |
| `?route=docentes.edit&id=...` / `docentes.update` | GET / POST | Actualizar (U) |
| `docentes.delete` | POST | Eliminar (D) |

Todas requieren sesión iniciada.

---

## Ejecución local

1. Instalar PHP 8.3 (extensiones `pdo_mysql`, `mbstring`, `openssl`) y MySQL o MariaDB.
2. Crear la base de datos ejecutando, en orden:
   ```
   database/01_crud_usuarios.sql   (usuario Estudiante, tabla users y admin base)
   database/02_docentes.sql        (tabla docentes y datos de ejemplo)
   ```
3. Copiar `.env.example` a `.env` y ajustar `DB_HOST`, `DB_PORT`, `DB_USERNAME=Estudiante`, `DB_PASSWORD=Developer`.
4. Levantar el servidor desde la raíz del proyecto:
   ```
   php -S localhost:8000
   ```
5. Abrir `http://localhost:8000/public/index.php` e iniciar sesión con `admin@crud.com` / `admin123`.

> Si SMTP no está configurado, el registro y la edición de usuarios funcionan igual: el fallo del correo solo se registra en el log.

### Pruebas

```
php tests/DocenteDomainTest.php            # reglas del dominio (26 casos)
php tests/DocenteApplicationTest.php       # casos de uso con adaptador en memoria (11 casos)
php tests/DocenteRepositoryMySQLTest.php   # integración con MySQL (6 casos, requiere la BD)
```
---

## Despliegue: Render + Supabase (PostgreSQL)

La base de datos en la nube es **Supabase (PostgreSQL)** y la aplicación corre en **Render** con Docker. Gracias a la arquitectura hexagonal, el cambio de motor solo tocó la infraestructura (`Connection` y una consulta); dominio y aplicación no cambiaron.

### Variables de entorno

Toda la configuración sale de variables de entorno (`EnvLoader`). En local se leen de `.env`; en Render se crean en *Environment* y tienen prioridad. Ver `.env.example`.

| Variable | Local (MariaDB) | Render (Supabase) |
|---|---|---|
| `DB_DRIVER` | `mysql` | `pgsql` |
| `DB_HOST` | `127.0.0.1` | `aws-0-<region>.pooler.supabase.com` |
| `DB_PORT` | `3306` | `5432` |
| `DB_DATABASE` | `crud_usuarios` | `postgres` |
| `DB_USERNAME` | `Estudiante` | `postgres.<id-del-proyecto>` |
| `DB_PASSWORD` | `Developer` | clave de la BD de Supabase |
| `DB_SSLMODE` | (vacío) | `require` |

### 1. Supabase

1. Crear un proyecto en supabase.com y guardar la clave de la base de datos.
2. *SQL Editor* → ejecutar `database/postgresql/01_crud_usuarios.sql` y luego `database/postgresql/02_docentes.sql`.
3. *Connect* → **Session pooler** y copiar host, puerto y usuario. Se usa el pooler porque la conexión directa de Supabase es IPv6 y Render no la soporta.

Los scripts activan *Row Level Security* sin políticas: la API REST pública de Supabase no puede leer las tablas, mientras que la aplicación (que conecta como propietaria) funciona normal.

### 2. Render

1. *New* → **Blueprint** → elegir este repositorio (usa `render.yaml`), o *New* → *Web Service* → runtime **Docker**.
2. Completar las variables marcadas como secretas: `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` (y SMTP si se desea).
3. Al terminar el despliegue, abrir `https://<servicio>.onrender.com/` e iniciar sesión con `admin@crud.com` / `admin123`.

> El plan gratis de Render suspende el servicio por inactividad: la primera carga puede tardar cerca de un minuto. También bloquea los puertos SMTP: el envío de correo falla, pero la aplicación sigue funcionando y el error queda en el log.

### Docker en local (opcional)

```
docker build -t crud-docentes .
docker run -p 8080:80 --env-file .env crud-docentes
```