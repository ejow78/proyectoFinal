<?php
require __DIR__ . '/includes/config.php';

$nombre = $_POST["nombre"] ?? '';
$apellido = $_POST["apellido"] ?? '';
$dni = $_POST["dni"] ?? '';
$genero = $_POST["genero"] ?? '';
$localidad = $_POST["localidad"] ?? '';
$direccion = $_POST["direccion"] ?? '';
$email = $_POST["email"] ?? '';
$telefono = $_POST["telefono"] ?? '';
$carrera = $_POST["carrera"] ?? '';

$errores = [];
foreach (['nombre', 'apellido', 'dni', 'genero', 'localidad', 'direccion', 'email', 'carrera'] as $c) {
    if (empty($$c)) {
        $errores[] = "El campo $c es obligatorio";
    }
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido";
}

if (empty($errores)) {
    $stmt = $conn->prepare("INSERT INTO preinscripciones
      (nombre, apellido, dni, genero, localidad, direccion, email, telefono, carrera)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
      "sssssssss",
      $nombre,
      $apellido,
      $dni,
      $genero,
      $localidad,
      $direccion,
      $email,
      $telefono,
      $carrera
    );

    if ($stmt->execute()) {
        $_SESSION['flash_ok'] = "¡Preinscripción enviada exitosamente!";
    } else {
        $_SESSION['flash_error'] = "Error al guardar la inscripción: " . $conn->error;
    }
    
    $stmt->close();

} else {
    $_SESSION['flash_error'] = implode("<br>", $errores);
}

$conn->close();
header("Location: " . BASE_URL . "preinscripcion.php");
exit;
?>