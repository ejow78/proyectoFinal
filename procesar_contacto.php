<?php
// Incluir config.php (que ya incluye conect.php y session_start())
require __DIR__ . '/includes/config.php';

// Los 'name' de tu formulario de contacto
$nombre = $_POST["firstName"] ?? '';
$apellido = $_POST["lastName"] ?? '';
$email = $_POST["email"] ?? '';
$telefono = $_POST["phone"] ?? '';
$interes = $_POST["interest"] ?? '';
$mensaje = $_POST["message"] ?? '';

$errores = [];
// Validar campos obligatorios
if (empty($nombre)) $errores[] = "El campo Nombre es obligatorio";
if (empty($apellido)) $errores[] = "El campo Apellido es obligatorio";
if (empty($mensaje)) $errores[] = "El campo Mensaje es obligatorio";

// Validar email
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido";
}

if (empty($errores)) {
    // Si no hay errores, proceder con la inserción
    $stmt = $conn->prepare("INSERT INTO mensajes_contacto
      (nombre, apellido, email, telefono, interes, mensaje)
      VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
      "ssssss",
      $nombre,
      $apellido,
      $email,
      $telefono,
      $interes,
      $mensaje
    );

    if ($stmt->execute()) {
        // === LÓGICA DE ÉXITO ===
        $_SESSION['flash_ok'] = "¡Mensaje enviado exitosamente!";
    } else {
        // === LÓGICA DE ERROR ===
        $_SESSION['flash_error'] = "Error al enviar el mensaje: " . $conn->error;
    }
    
    $stmt->close();

} else {
    // === LÓGICA DE ERROR DE VALIDACIÓN ===
    $_SESSION['flash_error'] = implode("<br>", $errores);
}

$conn->close();

// Redirigir de vuelta a 'contacto.php'
header("Location: " . BASE_URL . "contacto.php");
exit;
?>