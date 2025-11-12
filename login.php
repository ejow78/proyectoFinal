<?php
require 'includes/config.php';

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ya estás logueado, ir al panel de admin
if (isset($_SESSION['usuario'])) {
    header("Location: " . ADMIN_URL . "paneldecontrol.php");
    exit();
}

$error = '';
$referrer = isset($_GET['referrer']) ? $_GET['referrer'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL . 'index.php');

// Validar que el referrer sea del mismo dominio (seguridad)
$parsed_referrer = parse_url($referrer);
$parsed_base = parse_url('http://' . $_SERVER['HTTP_HOST'] . '/');
if ($parsed_referrer['host'] !== $parsed_base['host']) {
    $referrer = BASE_URL . 'index.php';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $referrer_post = trim($_POST['referrer'] ?? BASE_URL . 'index.php');

    if (!empty($usuario) && !empty($password)) {
        $sql = "SELECT id, usuario, password, rol FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['rol'] = $row['rol'];
                header("Location: " . $referrer_post);
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }

        $stmt->close();
    } else {
        $error = "Por favor completa todos los campos.";
    }
}

$conn->close(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - IES La Cocha</title>
    <link rel="stylesheet" href="assets/css/styles-auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    
    <!-- Login Form -->
    <main class="auth-main">
        <div class="container">
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <a href="<?php echo BASE_URL; ?>index.php" class="logo-link">
                                <h1>IES La Cocha</h1>
                            </a>
                            <a href="<?php echo htmlspecialchars($referrer); ?>" class="back-button" title="Volver">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>

                    <div class="auth-form-container">
                        <form class="auth-form" method="POST" action="login.php">
                            <input type="hidden" name="referrer" value="<?php echo htmlspecialchars($referrer); ?>">
                            <div class="form-group">
                                <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                            </div>

                            <div class="form-group">
                                <input type="password" id="password" name="password" placeholder="Contraseña" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <button type="submit" class="auth-button">Iniciar Sesión</button>

                            <?php if (!empty($error)): ?>
                                <div class="error" style="color:#a00;margin-top:10px;">
                                    <?= htmlspecialchars($error) ?>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
</body>
</html>
