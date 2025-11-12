<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnicatura Superior en Agroindrustria de los Alimentos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
   <?php include 'includes/header.php'; ?>   
    <!-- Main Content -->
    <main>
        <!-- mini menu -->
        <section class="breadcrumb-section">
            <div class="container">
                <nav class="breadcrumb">
                    <a href="../index.html" class="breadcrumb-link">Inicio</a>
                    <span class="breadcrumb-separator">></span>
                    <a href="../carreras.php" class="breadcrumb-link">Carreras</a>
                    <span class="breadcrumb-separator">></span>
                    <span class="breadcrumb-current">Tecnicatura Superior en Agroindrustria de los Alimentos</span>
                </nav>
            </div>
        </section>

        <!-- header carrera -->
        <section class="career-header">
            <div class="container">
                <div class="career-header-content">
                    <div class="career-info">
                        <h1 class="career-title">Tecnicatura Superior en Agroindrustria de los Alimentos</h1>
                        <p class="career-description">
                            La Tecnicatura en Desarrollo de Software brinda una formación práctica y actualizada en el área de las tecnologías de la información. Los estudiantes se introducen en la programación, el diseño de aplicaciones y el uso de herramientas digitales que responden a las demandas del mercado laboral. El objetivo es formar técnicos capaces de adaptarse a distintos entornos de trabajo, ya sea en empresas, instituciones o emprendimientos propios, contribuyendo al crecimiento del sector tecnológico y digital.
                        </p>
                    </div>
                    <div class="career-hero-image">
                        <img src="../assets/img/how-to-choose-your-programming-language-for-your-software.jpg" alt="Desarrollador de Software trabajando" class="hero-illustration">
                    </div>
                </div>
            </div>
        </section>

        <!-- Detalles carrera -->
        <section class="career-details">
            <div class="container">
                <div class="career-details-grid">
                    <!-- Perfil del Egresado -->
                    <div class="detail-card">
                        <h3 class="detail-title">Perfil del egresado</h3>
                        <div class="detail-content">
                            <p>Capaz de analizar requerimientos, construir interfaces, programar backends y bases de datos, y desplegar aplicaciones.</p>
                            <ul class="skills-list">
                                <li>Desarrollo de aplicaciones web y móviles</li>
                                <li>Programación en múltiples lenguajes</li>
                                <li>Gestión de bases de datos</li>
                                <li>Metodologías ágiles de desarrollo</li>
                                <li>Testing y control de calidad</li>
                                <li>Trabajo en equipo y comunicación efectiva</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Plan de Estudios -->
                    <div class="detail-card">
                        <h3 class="detail-title">Plan de estudios</h3>
                        <div class="detail-content">
                            <div class="curriculum-year">
                                <button class="curriculum-toggle" onclick="toggleCurriculum('año1')">
                                    <span>Primer Año</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="curriculum-content" id="año1">
                                    <ul class="subjects-list">
                                        <li>Pedagogía</li>
                                        <li>Didactica General</li>
                                        <li>Psicología Educacional</li>
                                        <li>Lectura Escritura y Oralidad</li>
                                        <li>Historia Mundial I</li>
                                        <li>Problema de Historia y Filosofia</li>
                                        <li>Prehistoria y Arqueologia</li>
                                        <li>Practicas Profesional</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="curriculum-year">
                                <button class="curriculum-toggle" onclick="toggleCurriculum('año2')">
                                    <span>Segundo Año</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="curriculum-content" id="año2">
                                    <ul class="subjects-list">
                                        <li>Programación II</li>
                                        <li>Base de Datos II</li>
                                        <li>Taller Programacion II</li>
                                        <li>Inglés Técnico II</li>
                                        <li>Matematica II</li>
                                        <li>Estadística Aplicada</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="curriculum-year">
                                <button class="curriculum-toggle" onclick="toggleCurriculum('año3')">
                                    <span>Tercer Año</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="curriculum-content" id="año3">
                                    <ul class="subjects-list">
                                        <li>asdasd</li>
                                        <li>asdasd</li>
                                        <li>asdsad</li>
                                        <li>asdasd</li>
                                        <li>asdasd</li>
                                        <li>asdasd</li>
                                    </ul>
                                </div>
                            </div>
                              <div class="curriculum-year">
                                <button class="curriculum-toggle" onclick="toggleCurriculum('año4')">
                                    <span>Cuarto Año</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="curriculum-content" id="año4">
                                    <ul class="subjects-list">
                                        <li>Programación II</li>
                                        <li>Base de Datos II</li>
                                        <li>Taller Programacion II</li>
                                        <li>Inglés Técnico II</li>
                                        <li>Matematica II</li>
                                        <li>Estadística Aplicada</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Duración y Modalidad -->
                    <div class="detail-card">
                        <h3 class="detail-title">Duración y modalidad</h3>
                        <div class="detail-content">
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <strong>Duración:</strong>
                                    <p>3 años</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-graduation-cap"></i>
                                <div>
                                    <strong>Modalidad:</strong>
                                    <p>Presencial</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <div>
                                    <strong>Horarios:</strong>
                                    <p>Turno Noche: 18:00 - 22:30 hs</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-certificate"></i>
                                <div>
                                    <strong>Título:</strong>
                                    <p>Técnico Superior en Desarrollo de Software</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="career-cta">
                    <div class="cta-content">
                        <h3>¿Interesado en esta carrera?</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur, cumque fugit obcaecati repudiandae sapiente totam ipsum eveniet debitis. Laborum illum vero vel impedit odit architecto, temporibus sapiente dolor cumque tempore.</p>
                        <div class="cta-buttons">
                            <a href="#" class="btn-primary">Inscribirme</a>
                            <a href="../contacto.html" class="btn-secondary">Más información</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/script.js"></script>
</body>
</html>
