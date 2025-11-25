# Proyecto Final – Remodelación del Sitio Web del Instituto de Ensenñanza Superior La Cocha

Este proyecto forma parte de la materia Laboratorio de Programación. Su objetivo es rediseñar y modernizar el sitio web institucional del Instituto de Enseñanza Superior La Cocha, poniendo especial énfasis en la digitalización del proceso de preinscripción.

## Objetivos del Proyecto

- Modernizar el Diseño: Actualizar el diseño visual del sitio institucional a un estándar moderno, limpio y responsivo.
- Digitalizar Inscripciones: Reemplazar el proceso manual de inscripción por un formulario de preinscripción digital.
- Mejorar la UX: Optimizar la experiencia de usuario y la navegación en todo el sitio.
- Gestión Administrativa: Crear un panel de control privado para que los docentes administrativos puedan consultar, gestionar, filtrar y editar las preinscripciones de los alumnos de forma no presencial.
- Implementar Seguridad: Añadir un sistema de autenticación seguro y gestión de sesiones con roles de usuario.

## Tecnologías Frontend

- HTML5: para la estructura de las páginas.
- CSS3: para los estilos visuales.
- Bootstrap 5: para diseño responsive y componentes modernos.
- JavaScript: para validar formularios y agregar interactividad básica.
  
## Tecnologías Backend

- PHP: Como lenguaje principal del lado del servidor.
- MySQL: Como sistema de gestión de base de datos (a través de mysqli).

## Estructura de Archivos

```
proyectoFinal/
├── admin/
│   ├── paneldecontrol.php      # (Ver, filtrar y buscar mensajes e inscripciones)
│   ├── crear_inscripcion.php   # (Formulario para crear inscripciones)
│   ├── editar_inscripcion.php  # (Formulario para editar inscripciones)
│   ├── inscripciones_json.php  # (Lógica de exportacion de tabla de inscripciones)
│   └── eliminar_inscripcion.php # (Lógica para eliminar entries)  
├── assets/
│   ├── css/                    # (styles.css, stylespanel.css, styles-auth.)
│   ├── js/                     # (script.js)
│   └── img/                    # (Logos, imagenes contenido, etc.)
├── carreras/
│   ├── profesorado-historia.php
│   ├── tecnicatura-software.php
│   ├── profesorado-matematica.php
│   ├── tecnicatura-agropecuaria.php
│   └── tecnicatura-agroindustria-alimentos.php
├── includes/
│   ├── conect.php              # (Conexión a la DB)
│   ├── config.php              # (Constantes, sesiones y config global)
│   ├── header.php              # (Cabecera reutilizable)
│   └── footer.php              # (Pie de página reutilizable)
├── index.php                   # (Página de inicio)
├── carreras.php                # (Listado de carreras)
├── contacto.php                # (Formulario de contacto)
├── login.php                   # (Inicio de sesión de admin)
├── logout.php                  # (Cierre de sesión)
├── preinscripcion.php          # (Formulario de preinscripción público)
├── procesar_contacto.php       # (Formulario de preinscripción público)
└── procesar_registro.php       # (Recibe el POST de preinscripcion.php)
```

## Páginas del Sitio

- Paginas institucionales: Página de inicio, listado de carreras y paginas de detalles de cada una.
- Formulario de Preinscripción: Un formulario (`preinscripcion.php`) que valida y guarda los datos del aspirante en la base de datos.
- Formulario de Contacto: Un formulario (`contacto.php`) que procesa y guarda los mensajes del usuario en la base de datos.
***Ambos formularios usan mensajes "flash" (guardados en `$_SESSION`) para mostrar notificaciones de éxito o error al usuario después de redirigirlo.***

## Administración de Sesiones

- Sistema de Autenticación: Login (`login.php`) que verifica usuarios contra la base de datos usando `password_verify` para contraseñas hasheadas.
- Gestión de Sesiones: El archivo `config.php` centraliza `session_start()` y las constantes de rutas (`BASE_URL`, `ADMIN_URL`).
- Protección de Rutas: El panel verifica que el usuario haya iniciado sesión y tenga el rol de 'admin' para poder acceder.
  
## Panel Admin
- Organización: La interfaz separa "Preinscripciones" y "Mensajes" en dos pestañas claras, cada una con su propio contador.
## Gestión de Preinscripciones
- CRUD Completo: Permite Crear, Leer (con paginación), Editar y Eliminar inscripciones.
- Búsqueda y Filtros: Permite buscar por nombre/apellido/DNI y filtrar por carrera o localidad.
## Gestión de Mensajes
- Lectura y Borrado:** Permite Leer (con paginación) y Eliminar los mensajes de contacto
***Paginación Independiente: Cada pestaña maneja su propia paginación para no interferir con la otra.***

## Funcionalidades JavaScript

El archivo `script.js` incluye funciones que mejoran la experiencia del usuario al interactuar con los formularios de login, registro y navegacion en general.
- Navegación Móvil: Controla la lógica del menú de hamburguesa (`mobileToggle`).
- Barra de Navegación Adhesiva: Detecta el scroll y añade la clase `.scrolled` a la barra de navegación.
- Carrusel de Imágenes: Maneja el carrusel de la página de inicio, con avance automático y botones.
- Botón de Mostrar/Ocultar Contraseña: La función `togglePassword` mejora la usabilidad en la página de `login.php`.
- Planes de Estudio Desplegables: La función `toggleCurriculum` crea un efecto de "acordeón" para mostrar y ocultar las materias en las páginas de carreras.

## Diseño Visual

- Se utilizaron clases de Bootstrap para construir un diseño moderno y responsive.
- Los estilos en `styles.css` personalizan colores, fuentes y disposición para mantener coherencia visual con el estilo del instituto.

## Cómo ejecutar el proyecto
Este proyecto requiere un entorno de servidor PHP y una base de datos MySQL.

1.  Clonar el Repositorio:
    ```bash
    git clone https://github.com/ejow78/proyectoFinal.git
    ```
2.  Mover Archivos: Move la carpeta `proyectoFinal` al directorio `htdocs` de tu instalación de XAMPP (o `www` en WAMP).
    
3.  Configurar la Base de Datos:
    * Abrí `phpMyAdmin` (usualmente `http://localhost/phpmyadmin`).
    * Crea una nueva base de datos.
    * Ejecuta las siguientes consultas SQL para crear las tablas:

    ```sql
    -- Tabla para las preinscripciones
    CREATE TABLE `preinscripciones` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nombre` varchar(100) NOT NULL,
      `apellido` varchar(100) NOT NULL,
      `dni` varchar(10) NOT NULL,
      `genero` varchar(20) NOT NULL,
      `localidad` varchar(100) NOT NULL,
      `direccion` varchar(255) NOT NULL,
      `email` varchar(100) NOT NULL,
      `telefono` varchar(20) NOT NULL,
      `carrera` varchar(100) NOT NULL,
      `creadoa` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabla para los mensajes de contacto
    CREATE TABLE `mensajes_contacto` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nombre` varchar(100) NOT NULL,
      `apellido` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `telefono` varchar(50) DEFAULT NULL,
      `interes` varchar(100) DEFAULT NULL,
      `mensaje` text NOT NULL,
      `creadoa` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabla para los usuarios administradores
    CREATE TABLE `usuarios` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `usuario` varchar(50) NOT NULL,
      `password` varchar(255) NOT NULL,
      `rol` varchar(20) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```
4.  Revisar Conexión: Abri `includes/conect.php` y asegurate de que el usuario (`$username: "root";`), la contraseña (`$password: "";`) y el nombre de la base de datos (`$dbname = "";`)  coincidan con la configuración de tu XAMPP o WAMP Server.
    
5.  Crear un Usuario Admin:
    - Para crear la contraseña hasheada, dirigite `http://localhost/proyectoFinal/admin/gener_contra_hash.php` en tu navegador. Usa la contraseña que prefieras.
    - Copia el hash que se genera.
    - Inserta tu usuario admin en la tabla `usuarios`. (Reemplaza `[HASH_GENERADO]` por el hash que copiaste).
    ```sql
    INSERT INTO `usuarios` (`usuario`, `password`, `rol`) 
    VALUES ('admin', '[HASH_GENERADO]', 'admin');
    ```

## Autores

- Nombres: Diaz Santiago y Ortiz Edgar Javier
- Materia: Laboratorio de Programación
- Año: 2025
