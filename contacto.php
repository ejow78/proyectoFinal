<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - IES La Cocha</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <img src="assets/img/LOGOIES.png" alt="Logo IES" class="header-logo">
                <div class="header-text">
                    <h1>Instituto de Enseñanza Superior La Cocha</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Navegacionn -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-content">
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">
                            Gestión Académica <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-link">Pre-Inscripción</a></li>
                            <li><a href="#" class="dropdown-link">Formularios</a></li>
                            <li><a href="#" class="dropdown-link">Fechas Exámenes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">
                            Carreras <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-link">Profesorado de Educación Secundaria en Historia</a></li>
                            <li><a href="#" class="dropdown-link">Profesorado de Educación Secundaria en Matemáticas</a></li>
                            <li><a href="#" class="dropdown-link">Técnico Superior en Gestión de Producción Agropecuaria</a></li>
                            <li><a href="#" class="dropdown-link">Técnico Superior en Agroindustria de los Alimentos</a></li>
                            <li><a href="#" class="dropdown-link">Técnico Superior en Desarrollo de Software</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="http://titulos.educaciontuc.gov.ar:88/consultaonline.aspx" target="_blank" class="nav-link">Consulta de Título</a>
                    </li>
                    <li class="nav-item">
                        <a href="contacto.html" class="nav-link active">Contacto</a>
                    </li>
                </ul>
                <a href="login.html" class="btn-login">
                    Iniciar Sesión
                </a>
                <button class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Contenido Body -->
    <main>
        <section class="section contact">
            <div class="container">
                <div class="section-header">
                    <h2>Contáctanos</h2>
                    <p>¿Tenes preguntas? Estamos aquí para ayudarte</p>
                </div>
                <div class="contact-content">
                    <!-- Form Contacto -->
                    <div class="contact-form-container">
                        <form class="contact-form" id="contactForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstName">Nombre *</label>
                                    <input type="text" id="firstName" name="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Apellido *</label>
                                    <input type="text" id="lastName" name="lastName" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="interest">Área de Interés</label>
                                <select id="interest" name="interest">
                                    <option value="">Selecciona una opción</option>
                                    <option value="alimentos">Técnico Superior en Agroindustria de los Alimentos</option>
                                    <option value="historia">Profesorado de Educación Secundaria en Historia</option>
                                    <option value="matematicas">Profesorado de Educación Secundaria en Matemáticas</option>
                                    <option value="agropecuaria">Técnico Superior en Gestión de Producción Agropecuaria</option>
                                    <option value="software">Técnico Superior en Desarrollo de Software</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message">Mensaje *</label>
                                <textarea id="message" name="message" rows="5" placeholder="Contanos como podemos ayudarte..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">
                                Enviar Mensaje
                            </button>
                        </form>
                    </div>
                    
                    <!-- Mapa -->
                    <div class="map-container">
                        <div class="map-header">
                            <h3>Nuestra Ubicación</h3>
                            <p>Sarmiento 150, La Cocha, Tucumán, Argentina</p>
                        </div>
                        <div class="map-embed">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d589.0419800283813!2d-65.58946114225895!3d-27.770886768642367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9423f16bcd38a087%3A0xef7f4dbc47845da9!2sI.E.S%20La%20Cocha!5e0!3m2!1sen!2sar!4v1753326352843!5m2!1sen!2sar"
                                width="100%" 
                                height="400" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Información de Contacto</h3>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@ieslacocha.edu.ar</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>(0381) 123-4567</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Sarmiento 150, La Cocha, Tucumán</span>
                        </div>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="#">Carreras</a></li>
                        <li><a href="#">Admisiones</a></li>
                        <li><a href="contacto.html">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Institucional</h3>
                    <div class="institutional-logos">
                        <a href="https://www.argentina.gob.ar/educacion/infod" target="_blank" rel="noopener noreferrer">
                            <img src="assets/img/logo_infod.png" alt="Logo INFOD">
                        </a>
                        <a href="https://www.argentina.gob.ar/educacion" target="_blank" rel="noopener noreferrer">
                            <img src="assets/img/logo_ministerio.png" alt="Logo Ministerio">
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 IES La Cocha. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
