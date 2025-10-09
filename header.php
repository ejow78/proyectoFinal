<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!-- Header -->
 
<header class="header">
    <div class="container">
        <div class="header-content">
            <img src="assets/img/LOGOIES.png" alt="Logo IES" class="header-logo">
            <div class="header-text">
                <h1>Instituto de Enseñanza Superior La Cocha</h1>
            </div>
            <link rel="stylesheet" href="styles.css">
        </div>
    </div>
</header>

<!-- Navegación -->
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-content">
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">
                        Gestión Académica <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="preinscripcion.php" class="dropdown-link">Pre-Inscripción</a></li>
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
                        <li><a href="carreras/desarrollo-software.php" class="dropdown-link">Técnico Superior en Desarrollo de Software</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="http://titulos.educaciontuc.gov.ar:88/consultaonline.aspx" target="_blank" class="nav-link">Consulta de Título</a>
                </li>
                <li class="nav-item">
                    <a href="contacto.php" class="nav-link">Contacto</a>
                </li>
                <?php if (!empty($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <a href="paneldecontrol.php" class="nav-link">Panel de Control</a>
                    </li>
                <?php endif; ?>
                    <li>
                    <?php if (!empty($_SESSION['usuario'])): ?>
                    <span class="user-saludo"> Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></span>
                    <a href="logout.php" class="btn-auth">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="btn-auth">Iniciar Sesión</a>
                <?php endif; ?>
                </li>
            </ul>

            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>