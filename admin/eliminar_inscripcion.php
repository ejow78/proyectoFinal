<?php
session_start();
require __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location:  " . BASE_URL . "login.php");
    exit();
}

if ($_SESSION['rol'] !== 'admin') {
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Verificar que se recibió un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: " . ADMIN_URL . "paneldecontrol.php");
    exit();
}

$id = intval($_GET['id']);

// Eliminar la inscripción
$sql = "DELETE FROM preinscripciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = "Inscripción eliminada exitosamente";
    $_SESSION['tipo_mensaje'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al eliminar la inscripción: " . $conn->error;
    $_SESSION['tipo_mensaje'] = "danger";
}

$stmt->close();
$conn->close();

header("Location: paneldecontrol.php");
exit();
?>
