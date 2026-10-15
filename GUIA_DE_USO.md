# 🏋️ Guía rápida de uso — FitNova Gym

Sistema web de gestión de gimnasio (Proyecto Integrador — Programación Web III).

Esta guía explica cómo **iniciar el servidor local** y las **cuentas de acceso** para probar el sistema.

---

## 1. Requisitos previos

- Tener instalado **XAMPP** (incluye PHP 8.2 y MariaDB/MySQL).
- La base de datos `gimnasio_db` ya está creada y con datos de prueba (socios, planes, pagos, etc.).
- PHP y Composer ya están configurados en el PATH de este equipo.

---

## 2. Cómo iniciar el servidor

1. Abrí el **Panel de Control de XAMPP** y presioná **Start** en el módulo **MySQL**
   (Apache **no** es necesario para esta forma de levantar el sistema).

2. Abrí **PowerShell** y entrá a la carpeta del proyecto:

   ```powershell
   cd "C:\Users\TOÑO\Documents\PROYECTOS\proyecto integrador\gimnasio"
   ```

3. Iniciá el servidor de Laravel:

   ```powershell
   php artisan serve
   ```

4. Abrí el navegador en:

   **http://127.0.0.1:8000**

5. Para **detener** el servidor: volvé a la terminal y presioná `Ctrl + C`.

> 💡 Si el puerto 8000 está ocupado, podés usar otro:
> `php artisan serve --port=8001`

---

## 3. Usuarios y contraseñas (demo)

| Rol            | Email                      | Contraseña |
| -------------- | -------------------------- | ---------- |
| Administrador  | `admin@fitnova.com`        | `password` |
| Entrenador     | `entrenador@fitnova.com`   | `password` |
| Socio          | `socio@fitnova.com`        | `password` |

> Las tres cuentas usan la misma contraseña: `password`.
> Los demás registros del sistema (otros socios, etc.) son solo datos de prueba.

---

## 4. Qué puede hacer cada rol

**Administrador** (`admin@fitnova.com`)
- Ver el **Dashboard** con métricas y gráficos (socios activos, ingresos, morosos).
- Gestionar **Socios** (alta, edición, baja y búsqueda en vivo).
- Gestionar **Planes**, **Membresías** y **Pagos** (incluye reactivación de vencidas).
- Ver **Rutinas** y **Clases**.
- Ver **Reportes** y exportarlos a **PDF** y **CSV** con montos en **Bolivianos (Bs.)**.

**Entrenador** (`entrenador@fitnova.com`)
- Ver el **Dashboard**.
- Crear y administrar **Rutinas** y sus **Ejercicios**.
- Gestionar **Clases** y marcar **Asistencia** de los socios.
- Ver **Reportes**.

**Socio** (`socio@fitnova.com`)
- Ver el estado de su **membresía** y su **rutina** asignada.
- **Reservar** y **cancelar** clases grupales (según cupo).

---

## 5. Notas útiles

- **Reiniciar la base de datos con datos demo:**
  ```powershell
  php artisan migrate:fresh --seed
  ```
- **Regenerar el PDF de documentación:**
  ```powershell
  php artisan doc:generar
  ```
  (se guarda en `docs\Documentacion_FitNova.pdf`)
- **Configuración de la base de datos** (archivo `.env`): host `127.0.0.1`, puerto `3307`, base `gimnasio_db`.

---

## 6. Solución de problemas rápidos

| Problema | Solución |
| --- | --- |
| `Connection refused` o error de base de datos | Verificá que **MySQL** esté encendido en XAMPP. |
| Puerto ocupado | Usá `php artisan serve --port=8001`. |
| Los datos no aparecen | Ejecutá `php artisan migrate:fresh --seed`. |
| No carga el diseño (colores/estilos) | Ejecutá `npm install` y luego `npm run build`. |

---

FitNova Gym · Proyecto Integrador · Programación Web III
