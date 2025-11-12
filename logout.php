<?php
require __DIR__ . '/includes/config.php';

// Asegurar que la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destruir la sesión
session_unset();
session_destroy();

// Limpiar la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirigir con caché deshabilitado
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header('Location: ' . BASE_URL . 'index.php');
exit();
?>