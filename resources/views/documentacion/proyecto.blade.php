<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentación Técnica — {{ config('app.name') }}</title>
    <style>
        * { font-family: 'DejaVu Sans', Arial, sans-serif; }
        body { color: #1f2937; font-size: 11px; line-height: 1.5; }
        h1 { font-size: 22px; color: #312e81; margin: 0 0 4px 0; }
        h2 { font-size: 15px; color: #312e81; border-bottom: 2px solid #6366f1; padding-bottom: 4px; margin-top: 24px; }
        h3 { font-size: 12.5px; color: #4338ca; margin: 14px 0 6px 0; }
        p { margin: 4px 0; text-align: justify; }
        table { width: 100%; border-collapse: collapse; margin: 8px 0; font-size: 10px; }
        th { background: #6366f1; color: #fff; padding: 5px 7px; text-align: left; }
        td { border: 1px solid #c7d2fe; padding: 5px 7px; vertical-align: top; }
        tr:nth-child(even) td { background: #eef2ff; }
        .page-break { page-break-before: always; }
        .cover { text-align: center; margin-top: 120px; }
        .cover .logo { font-size: 40px; font-weight: bold; color: #312e81; }
        .cover .sub { font-size: 14px; color: #4f46e5; margin: 8px 0 30px 0; }
        .cover .meta { font-size: 12px; margin-top: 40px; line-height: 2; color: #374151; }
        ul { margin: 4px 0 4px 18px; padding: 0; }
        li { margin-bottom: 3px; text-align: justify; }
        .canvas td { width: 33%; font-size: 9.5px; }
        .canvas th { font-size: 10px; }
        .entity { display: inline-block; width: 31%; border: 1.5px solid #4338ca; border-radius: 6px; margin: 6px 1%; vertical-align: top; }
        .entity .title { background: #4338ca; color: #fff; padding: 4px 6px; font-weight: bold; font-size: 10px; }
        .entity ul { list-style: none; margin: 0; padding: 4px 8px; font-size: 9px; }
        .entity li { margin: 2px 0; }
        .entity .pk { color: #b91c1c; }
        .entity .fk { color: #0f766e; }
        .note { background: #eef2ff; border-left: 4px solid #6366f1; padding: 8px 10px; font-size: 10px; margin: 8px 0; }
        .code { font-family: monospace; background: #f3f4f6; padding: 1px 4px; border-radius: 3px; font-size: 10px; }
        small { color: #6b7280; }
        .footer { text-align: center; color: #9ca3af; font-size: 9px; margin-top: 30px; }
        .rb { background: #fef2f2; border-left: 4px solid #ef4444; padding: 8px 10px; font-size: 10px; margin: 8px 0; }
    </style>
</head>
<body>

<div class="cover">
    <div class="logo">💪 FitNova Gym</div>
    <div class="sub">Sistema Web de Gestión Integral para Gimnasios</div>

    <h1>Proyecto Integrador</h1>
    <p style="text-align:center; font-size:13px;"><strong>Documentación Técnica — El Artefacto</strong></p>

    <div class="meta">
        <strong>Asignatura:</strong> Programación Web III<br>
        <strong>Curso:</strong> 3er Año de Sistemas<br>
        <strong>Modalidad:</strong> En parejas (dúos)<br>
        <strong>Docente:</strong> ____________________________<br>
        <strong>Integrantes:</strong> ____________________________ y ____________________________<br>
        <strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
        <strong>Stack:</strong> PHP (Laravel) · MySQL/MariaDB · Blade · Tailwind · JavaScript
    </div>
</div>

<div class="page-break"></div>

<h2>Índice</h2>
<ol>
    <li>Definición del negocio</li>
    <li>Ingeniería de requerimientos</li>
    <li>Arquitectura de software</li>
    <li>Stack tecnológico y buenas prácticas</li>
</ol>

<h2>1. Definición del Negocio</h2>

<h3>1.1 Nombre de la empresa/emprendimiento</h3>
<p><strong>FitNova Gym</strong> es un gimnasio local que ofrece musculación, clases grupales, pileta y entrenamiento personalizado. Hoy lleva su administración en planillas de Excel y papel, lo que genera errores, pérdida de historial y mora no controlada.</p>

<h3>1.2 Modelo de negocio (Business Model Canvas)</h3>
<table class="canvas">
    <tr>
        <th colspan="3">Modelo Canvas</th>
    </tr>
    <tr>
        <th>Socios clave</th>
        <th>Actividades clave</th>
        <th>Propuesta de valor</th>
    </tr>
    <tr>
        <td>Entrenadores certificados, proveedores de equipamiento, servicios contables.</td>
        <td>Dictado de clases, planificación de rutinas, cobro de cuotas, mantenimiento del predio.</td>
        <td>Digitalización total de la gestión: socios, membresías, pagos, rutinas y clases en una sola plataforma, con reportes en tiempo real.</td>
    </tr>
    <tr>
        <th>Relaciones con clientes</th>
        <th>Canales</th>
        <th>Segmento de clientes</th>
    </tr>
    <tr>
        <td>Atención personalizada, seguimiento de morosos y recordatorios de vencimiento.</td>
        <td>Atención presencial en recepción y plataforma web accesible desde cualquier dispositivo.</td>
        <td>Jóvenes y adultos de la comunidad local (16-65 años) que buscan acondicionamiento físico.</td>
    </tr>
    <tr>
        <th>Recursos clave</th>
        <th>Estructura de costos</th>
        <th>Fuentes de ingresos</th>
    </tr>
    <tr>
        <td>Instalaciones, equipamiento, personal capacitado, sistema informático.</td>
        <td>Sueldos, servicios, alquiler, mantenimiento de equipos y hosting del sistema.</td>
        <td>Cuotas mensuales de membresías, planes trimestrales/anuales, planes dúo y clases grupales.</td>
    </tr>
</table>

<h3>1.3 Propuesta de valor</h3>
<p>FitNova es innovador porque resuelve el <strong>problema real</strong> de la gestión manual: <strong>¿qué necesidad resuelve?</strong> Controlar de forma confiable los socios, sus vencimientos y los cobros, evitando pérdida de ingresos por mora. <strong>¿Qué vende?</strong> Un servicio de gestión digital integral para el gimnasio. <strong>¿A quién va dirigido?</strong> Al administrador (dueño), a los entrenadores y a los socios, cada uno con su propio rol y vistas. Es <strong>necesario</strong> porque automatiza reportes, mantiene el historial y da una experiencia moderna y responsable al socio.</p>

<h2>2. Ingeniería de Requerimientos</h2>

<h3>2.1 Requerimientos Funcionales (RF)</h3>
<table>
    <tr><th style="width:8%">ID</th><th style="width:30%">Nombre</th><th>Descripción</th></tr>
    <tr><td>RF-01</td><td>Autenticación de usuarios</td><td>Registro, inicio y cierre de sesión con contraseñas encriptadas, validación y manejo de sesiones (sistema nativo de Laravel/Breeze).</td></tr>
    <tr><td>RF-02</td><td>Roles y permisos</td><td>Tres roles con vistas y acciones diferenciadas: administrador, entrenador y socio (middleware de rol).</td></tr>
    <tr><td>RF-03</td><td>Gestión de socios</td><td>Alta, edición, baja y búsqueda de socios (nombre, email, documento) con historial completo.</td></tr>
    <tr><td>RF-04</td><td>Gestión de planes</td><td>CRUD de planes de membresía con precio, duración y estado.</td></tr>
    <tr><td>RF-05</td><td>Asignación de membresías</td><td>Asociar un plan a un socio calculando automáticamente la fecha de vencimiento.</td></tr>
    <tr><td>RF-06</td><td>Registro de pagos</td><td>Cobro de cuotas con monto, método (efectivo/tarjeta/transferencia) y reactivación de membresías vencidas.</td></tr>
    <tr><td>RF-07</td><td>Control de mora</td><td>Detección automática de membresías vencidas y alertas en el panel principal.</td></tr>
    <tr><td>RF-08</td><td>Gestión de rutinas</td><td>Entrenadores asignan rutinas a socios con ejercicios parametrizados (series, repeticiones, peso).</td></tr>
    <tr><td>RF-09</td><td>Agenda de clases</td><td>Alta de clases grupales con cupo, fecha, hora y entrenador a cargo.</td></tr>
    <tr><td>RF-10</td><td>Inscripción a clases</td><td>El socio se inscribe/cancela en clases verificando cupo; el entrenador marca asistencia.</td></tr>
    <tr><td>RF-11</td><td>Dashboard y reportes</td><td>Métricas (ingresos, socios activos, morosos), gráficos y exportación de reportes a CSV.</td></tr>
    <tr><td>RF-12</td><td>Búsqueda asincrónica</td><td>Búsqueda de socios en tiempo real mediante JavaScript (Fetch) contra una API JSON.</td></tr>
</table>

<h3>2.2 Requerimientos No Funcionales (RNF)</h3>
<table>
    <tr><th style="width:8%">ID</th><th style="width:30%">Categoría</th><th>Especificación</th></tr>
    <tr><td>RNF-01</td><td>Rendimiento</td><td>Tiempo de respuesta menor a 2 segundos por página en condiciones normales de uso local.</td></tr>
    <tr><td>RNF-02</td><td>Responsividad</td><td>Diseño 100% responsivo (Tailwind CSS) adaptado a desktop, tablet y móvil.</td></tr>
    <tr><td>RNF-03</td><td>Seguridad</td><td>Contraseñas con hash bcrypt, protección CSRF en formularios y protección de rutas por rol.</td></tr>
    <tr><td>RNF-04</td><td>Compatibilidad</td><td>Compatibilidad con navegadores modernos (Chrome, Firefox, Edge) y versiones recientes de PHP 8.2+.</td></tr>
    <tr><td>RNF-05</td><td>Usabilidad</td><td>Interfaz en español, mensajes de éxito/error claros y validación de formularios en el servidor.</td></tr>
    <tr><td>RNF-06</td><td>Mantenibilidad</td><td>Código limpio y modular (controladores, modelo, Form Requests), formateado con Laravel Pint.</td></tr>
    <tr><td>RNF-07</td><td>Disponibilidad</td><td>Funcionamiento continuo en el entorno XAMPP; instrucciones de instalación documentadas en README.</td></tr>
    <tr><td>RNF-08</td><td>Integridad de datos</td><td>Integridad referencial con claves foráneas, migraciones versionadas y sembradores reproducibles.</td></tr>
</table>

<div class="page-break"></div>

<h2>3. Arquitectura de Software</h2>

<h3>3.1 Arquitectura Modelo-Vista-Controlador (MVC) en Laravel</h3>
<p>Laravel implementa el patrón MVC de forma nativa y similar a otros frameworks PHP:</p>
<ul>
    <li><strong>Modelo (Models):</strong> clases Eloquent que representan cada tabla (por ejemplo <span class="code">User</span>, <span class="code">Plan</span>, <span class="code">Membresia</span>, <span class="code">Pago</span>). Contienen la lógica de negocio, relaciones y consultas.</li>
    <li><strong>Vista (Views Blade):</strong> plantillas HTML renderizadas con Blade, con componentes reutilizables y Tailwind CSS. Las vistas reciben datos ya preparados por el controlador.</li>
    <li><strong>Controlador (Controllers):</strong> orquestan la petición: reciben el <span class="code">Request</span>, validan con Form Requests, interactúan con los modelos (Eloquent ORM), y devuelven vistas o redirecciones.</li>
    <li><strong>Rutas (routes/web.php):</strong> el front controller centraliza la entrada de cada URL y aplica middleware de autenticación y de rol.</li>
</ul>

<h3>3.2 Flujo de datos entre Front-end y Back-end</h3>
<ol>
    <li>El navegador solicita una URL (ej. <span class="code">GET /socios</span>).</li>
    <li>El <strong>routing</strong> resuelve la ruta y aplica middleware (<span class="code">auth</span>, <span class="code">verified</span>, <span class="code">role</span>).</li>
    <li>El <strong>controlador</strong> recibe la petición, valida con la Form Request y consulta los <strong>modelos Eloquent</strong>.</li>
    <li>Eloquent traduce las consultas a SQL sobre <strong>MySQL/MariaDB</strong> mediante migraciones y devuelve colecciones de objetos.</li>
    <li>El controlador pasa los datos a la <strong>vista Blade</strong>, que genera el HTML con Tailwind.</li>
    <li>Para dinamismo, el <strong>JavaScript (Fetch)</strong> consulta endpoints JSON (ej. búsqueda de socios) y actualiza el DOM sin recargar la página.</li>
    <li>Los formularios envían datos con token <strong>CSRF</strong>; los controladores procesan, guardan y redirigen con mensajes flash de sesión.</li>
</ol>

<div class="note"><strong>Flujo resumido:</strong> Routes → Middleware → Controller → Form Request (validación) → Model (Eloquent) → MySQL ⇄ Model → Controller → View (Blade/Tailwind) → HTML/JS.</div>

<h3>3.3 Modelado de la Base de Datos (DER optimizado para MySQL)</h3>
<p>La base <span class="code">gimnasio_db</span> se crea con migraciones de Laravel y se siembra con dados demo. Las claves primarias se marcan en <span class="code">rojo</span> y las foráneas en <span class="code">verde</span>.</p>

<div>
    <div class="entity">
        <div class="title">users</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li>name</li>
            <li>email (UQ)</li>
            <li>password</li>
            <li>role (admin/entrenador/socio)</li>
            <li>telefono, documento</li>
            <li>fecha_nacimiento</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">planes</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li>nombre</li>
            <li>descripcion</li>
            <li>precio</li>
            <li>duracion_meses</li>
            <li>activo</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">membresias</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li class="fk">socio_id (FK→users)</li>
            <li class="fk">plan_id (FK→planes)</li>
            <li>fecha_inicio</li>
            <li>fecha_fin</li>
            <li>estado (activa/vencida)</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">pagos</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li class="fk">membresia_id (FK→membresias)</li>
            <li class="fk">socio_id (FK→users)</li>
            <li>monto</li>
            <li>fecha_pago</li>
            <li>metodo</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">rutinas</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li class="fk">entrenador_id (FK→users)</li>
            <li class="fk">socio_id (FK→users)</li>
            <li>titulo</li>
            <li>fecha_asignacion</li>
            <li>estado</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">ejercicios</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li class="fk">rutina_id (FK→rutinas)</li>
            <li>nombre</li>
            <li>series, repeticiones</li>
            <li>peso, orden</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">clases</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li class="fk">entrenador_id (FK→users)</li>
            <li>nombre</li>
            <li>fecha, hora</li>
            <li>cupo</li>
        </ul>
    </div>
    <div class="entity">
        <div class="title">asistencias</div>
        <ul>
            <li class="pk">id (PK)</li>
            <li class="fk">clase_id (FK→clases)</li>
            <li class="fk">socio_id (FK→users)</li>
            <li>fecha</li>
            <li>asistio (bool)</li>
        </ul>
    </div>
</div>

<h3>Cardinalidad de las relaciones</h3>
<table>
    <tr><th>Relación</th><th>Tipo</th><th>Tabla puente / Clave foránea</th></tr>
    <tr><td>users (socio) → membresias</td><td>1:N</td><td>membresias.socio_id</td></tr>
    <tr><td>planes → membresias</td><td>1:N</td><td>membresias.plan_id</td></tr>
    <tr><td>membresias → pagos</td><td>1:N</td><td>pagos.membresia_id</td></tr>
    <tr><td>users (entrenador) → rutinas</td><td>1:N</td><td>rutinas.entrenador_id</td></tr>
    <tr><td>users (socio) → rutinas</td><td>1:N</td><td>rutinas.socio_id</td></tr>
    <tr><td>rutinas → ejercicios</td><td>1:N</td><td>ejercicios.rutina_id</td></tr>
    <tr><td>users (entrenador) → clases</td><td>1:N</td><td>clases.entrenador_id</td></tr>
    <tr><td>clases → asistencias</td><td>1:N</td><td>asistencias.clase_id</td></tr>
    <tr><td>users (socio) → asistencias</td><td>1:N</td><td>asistencias.socio_id</td></tr>
</table>

<div class="page-break"></div>

<h2>4. Stack Tecnológico y Buenas Prácticas</h2>

<table>
    <tr><th style="width:35%">Componente</th><th>Tecnología</th></tr>
    <tr><td>Entorno de desarrollo</td><td>XAMPP (Apache, PHP 8.2, MariaDB/MySQL)</td></tr>
    <tr><td>Back-end</td><td>PHP 8.2 · Framework Laravel 12 (rutas, Eloquent ORM, migraciones, validación, sesiones)</td></tr>
    <tr><td>Autenticación</td><td>Laravel Breeze (login, registro, olvido de contraseña, confirmación)</td></tr>
    <tr><td>Front-end</td><td>Blade · Tailwind CSS · JavaScript (Fetch) · Chart.js · Vite</td></tr>
    <tr><td>Base de datos</td><td>MySQL/MariaDB con migraciones y sembradores (Seeders + Factories)</td></tr>
    <tr><td>Calidad de código</td><td>Laravel Pint · Tests automatizados (PHPUnit / Pest derivado)</td></tr>
    <tr><td>Control de versiones</td><td>Git + GitHub con README de instalación</td></tr>
</table>

<h3>Buenas prácticas aplicadas</h3>
<ul>
    <li>Uso correcto de variables de entorno en <span class="code">.env</span> (nunca se suben credenciales al repositorio).</li>
    <li>Código limpio y modular: controladores ligeros, lógica de negocio en modelos, validación en Form Requests.</li>
    <li>Sembradores (Seeders/Factories) que reproducen datos de prueba para demostrar el sistema.</li>
    <li>Control de versiones con commits por fase y historial compartido del dúo.</li>
    <li>Integridad referencial de la base de datos garantizada por migraciones con claves foráneas.</li>
</ul>

<h3>Usuarios de demostración (password: <span class="code">password</span>)</h3>
<table>
    <tr><th>Rol</th><th>Email</th></tr>
    <tr><td>Administrador</td><td>admin@fitnova.com</td></tr>
    <tr><td>Entrenador</td><td>entrenador@fitnova.com</td></tr>
    <tr><td>Socio</td><td>socio@fitnova.com</td></tr>
</table>

<div class="rb"><strong>Repositorio y ejecución:</strong> el código fuente se encuentra en el repositorio Git del proyecto. Para reproducir el sistema se siguen las instrucciones del archivo <span class="code">README.md</span>: clonar, instalar dependencias con Composer y npm, configurar <span class="code">.env</span>, ejecutar migraciones y sembrar la base.</div>

<div class="footer">
    FitNova Gym · Proyecto Integrador · Programación Web III · 3er Año de Sistemas
</div>

</body>
</html>