<?php
session_start();
require __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Verificar que se recibió un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$conn = getConnection();

// Eliminar la inscripción
$sql = "DELETE FROM inscripciones WHERE id = ?";
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
closeConnection($conn);

header("Location: index.php");
exit();
?>
