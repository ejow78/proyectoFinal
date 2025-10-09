<?php
session_start();
$ok = $_SESSION['flash_ok']  ?? null;
$err = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_ok'], $_SESSION['flash_error']);
?>
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

  <?php if ($ok): ?>
  <div style="padding:10px;border-radius:6px;background:#e8f7ed;color:#1f7a3e;margin-bottom:12px">
    <?= htmlspecialchars($ok) ?>
  </div>
<?php endif; ?>

<?php if ($err): ?>
  <div style="padding:10px;border-radius:6px;background:#fde2e1;color:#8a1f1f;margin-bottom:12px">
    <?= htmlspecialchars($err) ?>
  </div>
<?php endif; ?>

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
                        <a href="index.php" class="nav-link">Inicio</a>
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
                            <li><a href="" class="dropdown-link">Profesorado de Educación Secundaria en Historia</a></li>
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
                        <a href="contacto.php" class="nav-link active">Contacto</a>
                    </li>
                </ul>
                <a href="login.php" class="btn-login">
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
        <section class="section preregistro">
            <div class="container">
                <div class="section-header">
                    <h2>Pre-Inscribite</h2>
                    <p>Completa el formulario</p>
                </div>
                <div class="preregistro-content">
      <div class="preregistro-form-container">
        <form class="registroform-form" id="registroform" action="procesarregistro.php" method="POST">
  
          <div class="form-row">
            <div class="form-group">
              <label for="nombre">Nombre *</label>
              <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
              <label for="apellido">Apellido *</label>
              <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
              <label for="dni">DNI *</label>
              <input type="number" id="dni" name="dni" required>
            </div>
            <div class="form-group">
              <label for="genero">Género *</label>
              <select id="genero" name="genero" required>
                <option value="" disabled selected hidden>Selecciona una opción</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="otrog">Otro/a</option>
              </select>
            </div>
          </div>


          <div class="form-row">
            <div class="form-group full">
              <label for="localidad">Localidad *</label>
              <select id="localidad" name="localidad" required>
                <option value="" disabled selected hidden>Selecciona una opción</option>
                <option value="alberdi">Alberdi</option>
                <option value="aguilares">Aguilares</option>
                <option value="concepcion">Concepcion</option>
                <option value="graneros">Graneros</option>
                <option value="lacocha">La Cocha</option>
                <option value="lamadrid">La Madrid</option>
                <option value="santana">Santa Ana</option>
                <option value="villabel">Villa Belgrano</option>
                <option value="otraloc">Otro/a</option>
              </select>
            </div>
            <div class="form-group">
              <label for="direccion">Dirección *</label>
              <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
              <label for="email">Email *</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <input type="tel" id="telefono" name="telefono" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group full">
              <label for="carrera">Carrera *</label>
              <select id="carrera" name="carrera" required>
                <option value="" disabled selected hidden>Selecciona una opción</option>
                <option value="alimentos">Técnico Superior en Agroindustria de los Alimentos</option>
                <option value="historia">Profesorado de Educación Secundaria en Historia</option>
                <option value="matematicas">Profesorado de Educación Secundaria en Matemáticas</option>
                <option value="agropecuaria">Técnico Superior en Gestión de Producción Agropecuaria</option>
                <option value="software">Técnico Superior en Desarrollo de Software</option>
                <option value="otro">Otro</option>
              </select>
            </div>

            <h5>Presentar de manera fisica Fotocopia de DNI (ambos lados) y Fotocopia Titulo / Constancia de titulo en tramite</h5>

          <button type="submit" class="btn-submit">Enviar Mensaje</button>
        </form>
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
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="#">Carreras</a></li>
                        <li><a href="#">Admisiones</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
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
</php>