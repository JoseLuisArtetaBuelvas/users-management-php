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

## Ejercicio 2: CRUDL de Universidad

Además de la entidad común **Usuario**, el proyecto implementa el CRUDL de la entidad **Universidad** respetando las mismas capas.

**Estudiante:** José Luis Arteta Buelvas

> Nota del historial: por un error de lectura del enunciado primero se implementó la entidad Docente (ejercicio 3). Al detectarlo se implementó Universidad (ejercicio 2) y luego se eliminó Docente en la rama `refactor/remove-docente`.

### Atributos y reglas de negocio

| Atributo | Regla (Value Object / Enum) |
|---|---|
| id | UUID v4 generado por la aplicación (`UniversidadId`) |
| nombre | 3 a 120 caracteres; letras, números y `. , - ' ( ) &`; único sin importar mayúsculas (`UniversidadNombre`) |
| categoria | `PUBLICA` o `PRIVADA` (`UniversidadCategoriaEnum`) |
| web | Obligatoria, URL `http(s)` válida (`UniversidadWeb`) |
| rector | 5 a 100 caracteres, solo letras y espacios (`UniversidadNombrePropio::rector`) |
| email | Formato válido, en minúsculas y único (`UniversidadEmail`) |
| acceso | `EXAMEN_ADMISION`, `PRUEBAS_SABER_11`, `INGRESO_DIRECTO`, `MIXTO` (`UniversidadAccesoEnum`) |
| telefono | 7 a 15 dígitos; admite `+`, espacios y guiones (`UniversidadTelefono`) |
| ciudad | 2 a 60 caracteres, solo letras y espacios (`UniversidadNombrePropio::ciudad`) |
| numeroCarreras | Entero de 1 a 500 (`UniversidadCantidad::numeroCarreras`) |
| numSedes | Entero de 1 a 100 (`UniversidadCantidad::numSedes`) |

Reglas del modelo (`UniversidadModel`): `esPublica()`, `esMultisede()` (más de una sede) y `carrerasPorSede()`. Es inmutable: `cambiarRector()` y `abrirSede()` devuelven una nueva instancia.

### Archivos por capa

| Capa | Elementos |
|---|---|
| Dominio | `UniversidadModel`, 7 Value Objects, 2 Enums, 11 excepciones, 3 eventos (`universidad.created/updated/deleted`) |
| Aplicación | 7 puertos de salida, 5 casos de uso (puertos de entrada), 3 commands, 2 queries, `UniversidadApplicationMapper`, 5 servicios |
| Infraestructura (adaptador) | `UniversidadPersistenceDto`, `UniversidadEntity`, `UniversidadPersistenceMapper`, `UniversidadRepositoryMySQL` |
| Infraestructura (entrypoint) | `CreateUniversidadWebRequest`, `UpdateUniversidadWebRequest`, `UniversidadResponse`, `UniversidadWebMapper`, `UniversidadController`, rutas `universidades.*` y vistas `Views/universidades` |
| Común | Registro en `ClassLoader` e inyección en `DependencyInjection` |

### Flujo de una operación (crear universidad)

```
Formulario HTML -> public/index.php (universidades.store) -> CreateUniversidadWebRequest
  -> UniversidadWebMapper -> CreateUniversidadCommand -> CreateUniversidadService (CreateUniversidadUseCase)
  -> UniversidadApplicationMapper -> UniversidadModel (Value Objects validan)
  -> GetUniversidadByNombrePort / GetUniversidadByEmailPort (unicidad)
  -> SaveUniversidadPort -> UniversidadRepositoryMySQL -> tabla universidades
```

### Rutas

| Ruta | Método | Operación |
|---|---|---|
| `?route=universidades.index&q=texto` | GET | Listar y buscar por nombre, ciudad, rector o correo (L) |
| `?route=universidades.create` / `universidades.store` | GET / POST | Registrar (C) |
| `?route=universidades.show&id=...` | GET | Consultar (R) |
| `?route=universidades.edit&id=...` / `universidades.update` | GET / POST | Actualizar (U) |
| `universidades.delete` | POST | Eliminar (D) |

Todas requieren sesión iniciada.

---

## Ejecución local

1. Instalar PHP 8.3 (extensiones `pdo_mysql`, `mbstring`, `openssl`) y MySQL o MariaDB.
2. Crear la base de datos ejecutando, en orden:
   ```
   database/01_crud_usuarios.sql   (usuario Estudiante, tabla users y admin base)
   database/02_universidades.sql   (tabla universidades y datos de ejemplo)
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
php tests/UniversidadDomainTest.php            # reglas del dominio (29 casos)
php tests/UniversidadApplicationTest.php       # casos de uso con adaptador en memoria (12 casos)
php tests/UniversidadRepositoryMySQLTest.php   # integración con la BD configurada en .env (6 casos)
```

---

## Despliegue: Render + Supabase (PostgreSQL)

La base de datos en la nube es **Supabase (PostgreSQL)** y la aplicación corre en **Render** con Docker. Gracias a la arquitectura hexagonal, el cambio de motor solo tocó la infraestructura (`Connection` y consultas de búsqueda portables); dominio y aplicación no cambiaron.

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
2. *SQL Editor* → ejecutar `database/postgresql/01_crud_usuarios.sql` y luego `database/postgresql/02_universidades.sql`.
3. *Connect* → **Session pooler** y copiar host, puerto y usuario. Se usa el pooler porque la conexión directa de Supabase es IPv6 y Render no la soporta.

Los scripts activan *Row Level Security* sin políticas: la API REST pública de Supabase no puede leer las tablas, mientras que la aplicación (que conecta como propietaria) funciona normal.

### 2. Render

1. *New* → **Blueprint** → elegir este repositorio (usa `render.yaml`), o *New* → *Web Service* → runtime **Docker**.
2. Completar las variables marcadas como secretas: `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` (y SMTP si se desea).
3. Al terminar el despliegue, abrir `https://<servicio>.onrender.com/` e iniciar sesión con `admin@crud.com` / `admin123`.

> El plan gratis de Render suspende el servicio por inactividad: la primera carga puede tardar cerca de un minuto. También bloquea los puertos SMTP: el envío de correo falla, pero la aplicación sigue funcionando y el error queda en el log.

### Docker en local (opcional)

```
docker build -t crud-universidades .
docker run -p 8080:80 --env-file .env crud-universidades
```