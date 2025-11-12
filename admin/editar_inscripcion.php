<?php
session_start();
require __DIR__ . '/../includes/config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] !== 'admin') {
    header("Location: paneldecontrol.php");
    exit();
}

$mensaje = "";
$tipo_mensaje = "";

if (!isset($_GET['id'])) {
    header("Location: paneldecontrol.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM preinscripciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: paneldecontrol.php");
    exit();
}

$inscripcion = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dni = trim($_POST['dni']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $genero = $_POST['genero'];
    $localidad = $_POST['localidad'];
    $direccion = trim($_POST['direccion']);
    $carrera = $_POST['carrera'];
    
    // Validaciones
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($email) || empty($telefono) || 
        empty($genero) || empty($localidad) || empty($direccion) || empty($carrera)) {
        $mensaje = "Todos los campos son obligatorios";
        $tipo_mensaje = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido";
        $tipo_mensaje = "danger";
    } else {
        $sql_update = "UPDATE preinscripciones SET nombre = ?, apellido = ?, dni = ?, email = ?, telefono = ?, 
                      genero = ?, localidad = ?, direccion = ?, carrera = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssssi", $nombre, $apellido, $dni, $email, $telefono, 
                                 $genero, $localidad, $direccion, $carrera, $id);
        
        if ($stmt_update->execute()) {
            $_SESSION['mensaje'] = "Inscripción actualizada exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: paneldecontrol.php");
            exit();
        } else {
            $mensaje = "Error al actualizar la inscripción: " . $conn->error;
            $tipo_mensaje = "danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Inscripción - Sistema de Inscripciones</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>stylespanel.css">
</head>
<body>
    <div class="edit-page-container">
        <div class="edit-card">
            <div class="edit-card-header">
                <h2>Editar Inscripción</h2>
                <p>Modifique los datos de la inscripción</p>
            </div>
            
            <div class="edit-card-body">
                <?php if (isset($mensaje) && $mensaje): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre <span class="required">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="<?php echo htmlspecialchars($inscripcion['nombre']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="form-label">Apellido <span class="required">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido" 
                                   value="<?php echo htmlspecialchars($inscripcion['apellido']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="dni" class="form-label">DNI <span class="required">*</span></label>
                            <input type="text" class="form-control" id="dni" name="dni" 
                                   value="<?php echo htmlspecialchars($inscripcion['dni']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="genero" class="form-label">Género <span class="required">*</span></label>
                            <select class="form-select" id="genero" name="genero" required>
                                <option value="">Seleccione...</option>
                                <option value="masculino" <?php echo ($inscripcion['genero'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="femenino" <?php echo ($inscripcion['genero'] == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="otro" <?php echo ($inscripcion['genero'] == 'otro') ? 'selected' : ''; ?>>Otro/a</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="localidad" class="form-label">Localidad <span class="required">*</span></label>
                            <select class="form-select" id="localidad" name="localidad" required>
                                <option value="">Seleccione...</option>
                                <option value="alberdi" <?php echo ($inscripcion['localidad'] == 'alberdi') ? 'selected' : ''; ?>>Juan Bautista Alberdi</option>
                                <option value="graneros" <?php echo ($inscripcion['localidad'] == 'graneros') ? 'selected' : ''; ?>>Graneros</option>
                                <option value="lacocha" <?php echo ($inscripcion['localidad'] == 'lacocha') ? 'selected' : ''; ?>>La Cocha</option>
                                <option value="aguilares" <?php echo ($inscripcion['localidad'] == 'aguilares') ? 'selected' : ''; ?>>Aguilares</option>
                                <option value="concepcion" <?php echo ($inscripcion['localidad'] == 'concepcion') ? 'selected' : ''; ?>>Concepción</option>
                                <option value="lamadrid" <?php echo ($inscripcion['localidad'] == 'lamadrid') ? 'selected' : ''; ?>>La Madrid</option>
                                <option value="santana" <?php echo ($inscripcion['localidad'] == 'santana') ? 'selected' : ''; ?>>Santa Ana</option>
                                <option value="villabel" <?php echo ($inscripcion['localidad'] == 'villabel') ? 'selected' : ''; ?>>Villa Belgrano</option>
                                <option value="otraloc" <?php echo ($inscripcion['localidad'] == 'otraloc') ? 'selected' : ''; ?>>Otro/a</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="form-label">Dirección <span class="required">*</span></label>
                            <input type="text" class="form-control" id="direccion" name="direccion" 
                                   value="<?php echo htmlspecialchars($inscripcion['direccion']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="form-label">Correo Electrónico <span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($inscripcion['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono <span class="required">*</span></label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                   value="<?php echo htmlspecialchars($inscripcion['telefono']); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="carrera" class="form-label">Carrera Deseada <span class="required">*</span></label>
                        <select class="form-select" id="carrera" name="carrera" required>
                            <option value="">Seleccione una carrera...</option>
                            <option value="alimentos" <?php echo ($inscripcion['carrera'] == 'alimentos') ? 'selected' : ''; ?>>Técnico Superior en Agroindustria de los Alimentos</option>
                            <option value="historia" <?php echo ($inscripcion['carrera'] == 'historia') ? 'selected' : ''; ?>>Profesorado de Educación Secundaria en Historia</option>
                            <option value="matematicas" <?php echo ($inscripcion['carrera'] == 'matematicas') ? 'selected' : ''; ?>>Profesorado de Educación Secundaria en Matemáticas</option>
                            <option value="agropecuaria" <?php echo ($inscripcion['carrera'] == 'agropecuaria') ? 'selected' : ''; ?>>Técnico Superior en Gestión de Producción Agropecuaria</option>
                            <option value="software" <?php echo ($inscripcion['carrera'] == 'software') ? 'selected' : ''; ?>>Técnico Superior en Desarrollo de Software</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <a href="paneldecontrol.php" class="btn btn-cancel">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Inscripción</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
