<?php
require 'conect.php';
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');



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
                header("Location: index.php");
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
    <link rel="stylesheet" href="styles-auth.css">
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
                        <a href="index.php" class="logo-link">
                            <h1>IES La Cocha</h1>
                        </a>
                    </div>

                    <div class="auth-form-container">
                        <form class="auth-form" method="POST" action="login.php">
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

    <script src="script.js"></script>
</body>
</html>
