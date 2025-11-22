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
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
<?php
$comunicado = "assets/comunicado.html";
if (file_exists($comunicado)) {
    echo file_get_contents($comunicado);
}
?>
</body>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/script.js"></script>
</body>
</html>
