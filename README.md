# 💪 FitNova Gym — Sistema de Gestión Integral para Gimnasios

Proyecto Integrador de **Programación Web III** (3er Año de Sistemas). Sistema web construido con **Laravel 12 + MySQL/MariaDB** que digitaliza la administración de un gimnasio: socios, planes, membresías, pagos, rutinas, ejercicios, clases y asistencias, con **tres roles de usuario** (administrador, entrenador y socio).

## Características

- 🔐 **Autenticación** con Laravel Breeze (login, registro, recuperación de contraseña).
- 🎭 **Roles y permisos**: vistas y acciones diferenciadas por rol mediante middleware.
  - **Administrador**: todo el panel de gestión (socios, planes, membresías, pagos, reportes).
  - **Entrenador**: rutinas personalizadas, agenda de clases y control de asistencia.
  - **Socio**: su membresía, su rutina, reserva/cancelación de clases.
- 📊 **Dashboard** con métricas: socios activos, ingresos, morosos, planes vigentes y gráficos.
- 🔎 **Búsqueda asincrónica de socios** con JavaScript (Fetch) contra una API JSON.
- 📄 **Reportes** con exportación a **CSV** y **PDF** (reporte general y de pagos).
- 💾 Modelo de datos con **8 tablas relacionadas**, migraciones, factories y seeders.
- 🎨 Interfaz **responsiva** con **Blade + Tailwind CSS + Chart.js**.

## Stack tecnológico

| Componente | Tecnología |
|---|---|
| Back-end | PHP 8.2 · Laravel 12 (Eloquent ORM, Migraciones, Validación) |
| Base de datos | MySQL / MariaDB (XAMPP) |
| Front-end | Blade · Tailwind CSS · JavaScript (Fetch) · Chart.js · Vite |
| Autenticación | Laravel Breeze |
| Calidad | Laravel Pint · PHPUnit (tests) |
| Git | GitHub |

## Requisitos

- [XAMPP](https://www.apachefriends.org/) (Apache + PHP ≥ 8.2 + MariaDB) o equivalente.
- [Composer](https://getcomposer.org/) ≥ 2.
- [Node.js](https://nodejs.org/) ≥ 20 y npm.

## Instalación (local con XAMPP)

> ⚠️ En este equipo la BD corre en el puerto **3307** (MariaDB de XAMPP). Si tu MySQL usa 3306, ajusta `DB_PORT`.

1. **Clonar** el repositorio:

   ```bash
   git clone <url-del-repositorio> gimnasio
   cd gimnasio
   ```

2. **Instalar dependencias:**

   ```bash
   composer install
   npm install
   ```

3. **Configurar el entorno** (copiar y editar):

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

   Edita `.env` con los datos de tu base:

   ```env
   APP_NAME="FitNova Gym"
   APP_LOCALE=es

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3307
   DB_DATABASE=gimnasio_db
   DB_USERNAME=gimnasio
   DB_PASSWORD=gimnasio2026
   ```

   Crea la base y el usuario en phpMyAdmin o por consola:

   ```sql
   CREATE DATABASE gimnasio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'gimnasio'@'localhost' IDENTIFIED BY 'gimnasio2026';
   GRANT ALL PRIVILEGES ON gimnasio_db.* TO 'gimnasio'@'localhost';
   ```

4. **Migrar y sembrar datos de prueba:**

   ```bash
   php artisan migrate --seed
   ```

5. **Compilar assets:**

   ```bash
   npm run build
   ```

6. **Levantar el servidor** (con Apache, o el servidor de desarrollo):

   ```bash
   php artisan serve
   ```

   Abre `http://127.0.0.1:8000`.

## Usuarios de demostración

Todas las contraseñas son `password`:

| Rol | Email |
|---|---|
| Administrador | `admin@fitnova.com` |
| Entrenador | `entrenador@fitnova.com` |
| Socio | `socio@fitnova.com` |

## Tests

```bash
php artisan test
```

Los tests se ejecutan contra la base `gimnasio_test` (MySQL) para replicar el entorno real.

## Documentación técnica

El documento formal (modelo canvas, 12 requerimientos funcionales, requerimientos no funcionales, arquitectura MVC, flujo de datos y DER) está en:

- [`docs/Documentacion_FitNova.pdf`](docs/Documentacion_FitNova.pdf)

Puede regenerarse con:

```bash
php artisan doc:generar
```

## Estructura del proyecto

```
app/
├── Console/Commands/       GenerarDocumentacion (PDF)
├── Http/
│   ├── Controllers/        10 controladores (Dashboard, Socio, Plan, Membresia, Pago, Rutina, Ejercicio, Clase, Asistencia, Reporte)
│   ├── Middleware/         EnsureUserRole
│   └── Requests/           11 Form Requests de validación
├── Models/                 8 modelos Eloquent (User, Plan, Membresia, Pago, Rutina, Ejercicio, Clase, Asistencia)
database/
├── migrations/             Esquema completo (users + 7 tablas de dominio)
├── factories/              Fábricas de datos de prueba
└── seeders/                DatabaseSeeder (idempotente, usuarios demo)
resources/views/            Vistas Blade + Tailwind y plantilla del PDF
routes/web.php              Rutas con middleware de rol
tests/Feature/              Smoke tests de las secciones por rol
docs/                       Documentación técnica en PDF
```

## Autores

Proyecto en parejas (dúo) — Programación Web III, 3er Año de Sistemas.