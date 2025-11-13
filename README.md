# Proyecto Final – Remodelación del Sitio Web del Instituto de Ensenñanza Superior La Cocha

Este proyecto forma parte de la materia Laboratorio de Programación. Su objetivo es rediseñar y modernizar el sitio web institucional.

## Objetivos del Proyecto

- Modernizar el Diseño: Actualizar el diseño visual del sitio institucional a un estándar moderno, limpio y responsivo.
- Digitalizar Inscripciones: Reemplazar el proceso manual de inscripción por un formulario de preinscripción digital.
- Mejorar la UX: Optimizar la experiencia de usuario y la navegación en todo el sitio.
- Gestión Administrativa: Crear un panel de control privado para que los docentes administrativos puedan consultar, gestionar, filtrar y editar las preinscripciones de los alumnos de forma no presencial.
- Implementar Seguridad: Añadir un sistema de autenticación seguro y gestión de sesiones con roles de usuario.

## Tecnologías Utilizadas

- HTML5: para la estructura de las páginas.
- CSS3: para los estilos visuales.
- Bootstrap 5: para diseño responsive y componentes modernos.
- JavaScript: para validar formularios y agregar interactividad básica.
- PHP: Como lenguaje principal del lado del servidor.
- MySQL: Como sistema de gestión de base de datos (a través de mysqli).

## Estructura de Archivos

```
proyectoFinal/
├── admin/
│   ├── paneldecontrol.php      # (Ver, filtrar y buscar inscripciones)
│   ├── crear_inscripcion.php   # (Formulario para crear)
│   ├── editar_inscripcion.php  # (Formulario para editar)
│   ├── eliminar_inscripcion.php # (Lógica para borrar)
│   └── gener_contra_hash.php   # (Utilidad para hashear contraseñas)
├── assets/
│   ├── css/                    # (styles.css, stylespanel.css, etc.)
│   ├── js/                     # (script.js)
│   └── img/                    # (Logos, banners, etc.)
├── carreras/
│   ├── profesorado-historia.php
│   ├── tecnicatura-software.php
│   └── ...                     # (Páginas para cada carrera)
├── includes/
│   ├── conect.php              # (Conexión a la BD MySQL)
│   ├── config.php              # (Constantes, sesiones y config global)
│   ├── header.php              # (Cabecera reutilizable)
│   └── footer.php              # (Pie de página reutilizable)
├── index.php                   # (Página de inicio)
├── carreras.php                # (Listado de carreras)
├── contacto.php                # (Formulario de contacto)
├── login.php                   # (Inicio de sesión de admin)
├── logout.php                  # (Cierre de sesión)
├── preinscripcion.php          # (Formulario de preinscripción público)
└── procesarregistro.php        # (Recibe el POST de preinscripcion.php)
```

## Páginas del Sitio

- index.html: Página de inicio con bienvenida institucional.
- contacto.html: Formulario de contacto que permite enviar mensajes.
- login.html: Formulario de inicio de sesión con validación básica.
- register.html: Registro de nuevos usuarios con validación de campos.

## Funcionalidades JavaScript

El archivo `script.js` incluye:

- Validación de campos vacíos en formularios.
- Confirmaciones de envío de datos.
- Funciones que mejoran la experiencia del usuario al interactuar con los formularios de login y registro.

## Diseño Visual

- Se utilizaron clases de Bootstrap para construir un diseño moderno y responsive.
- Los estilos en `styles.css` personalizan colores, fuentes y disposición para mantener coherencia visual con el estilo del instituto.

## Cómo Ejecutar el Proyecto

1. Clonar o descargar este repositorio.
2. Abrir el archivo `index.html` con cualquier navegador web moderno (Chrome, Firefox, Edge).
3. Navegar entre páginas a través del menú principal.
4. Probar formularios de login, registro y contacto.

> Nota: Este proyecto por el momento no utiliza backend ni base de datos. Las funcionalidades son de demostración con validación local.

## Autores

- Nombres: Diaz Santiago y Ortiz Edgar Javier
- Materia: Laboratorio de Programación
- Año: 2025
