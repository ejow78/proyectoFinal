<?php
session_start();
require_once 'config/conect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$mensaje = "";
$tipo_mensaje = "";

// Obtener el ID de la inscripción a editar
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$conn = getConnection();

// Obtener datos de la inscripción
$sql = "SELECT * FROM inscripciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$inscripcion = $resultado->fetch_assoc();

// Obtener lista de carreras
$sql_carreras = "SELECT * FROM carreras ORDER BY nombre";
$carreras = $conn->query($sql_carreras);

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $genero = $_POST['genero'];
    $localidad = $_POST['localidad'];
    $direccion = trim($_POST['direccion']);
    $carrera_id = $_POST['carrera_id'];
    
    // Validaciones
    if (empty($nombre) || empty($apellido) || empty($email) || empty($telefono) || 
        empty($genero) || empty($localidad) || empty($direccion) || empty($carrera_id)) {
        $mensaje = "Todos los campos son obligatorios";
        $tipo_mensaje = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido";
        $tipo_mensaje = "danger";
    } else {
        // Verificar si el email ya existe (excepto el actual)
        $sql_check = "SELECT id FROM inscripciones WHERE email = ? AND id != ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("si", $email, $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $mensaje = "El correo electrónico ya está registrado";
            $tipo_mensaje = "danger";
        } else {
            // Actualizar inscripción
            $sql_update = "UPDATE inscripciones SET nombre = ?, apellido = ?, email = ?, telefono = ?, 
                          genero = ?, localidad = ?, direccion = ?, carrera_id = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssssssii", $nombre, $apellido, $email, $telefono, 
                                     $genero, $localidad, $direccion, $carrera_id, $id);
            
            if ($stmt_update->execute()) {
                $mensaje = "Inscripción actualizada exitosamente";
                $tipo_mensaje = "success";
                
                // Actualizar los datos mostrados
                $inscripcion['nombre'] = $nombre;
                $inscripcion['apellido'] = $apellido;
                $inscripcion['email'] = $email;
                $inscripcion['telefono'] = $telefono;
                $inscripcion['genero'] = $genero;
                $inscripcion['localidad'] = $localidad;
                $inscripcion['direccion'] = $direccion;
                $inscripcion['carrera_id'] = $carrera_id;
            } else {
                $mensaje = "Error al actualizar la inscripción: " . $conn->error;
                $tipo_mensaje = "danger";
            }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2 class="text-center mb-4">
                <i class="bi bi-pencil-square"></i> Editar Inscripción
            </h2>
            
            <?php if ($mensaje): ?>
                <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                    <?php echo $mensaje; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="required">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               value="<?php echo htmlspecialchars($inscripcion['nombre']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="apellido" class="form-label">Apellido <span class="required">*</span></label>
                        <input type="text" class="form-control" id="apellido" name="apellido" 
                               value="<?php echo htmlspecialchars($inscripcion['apellido']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Correo Electrónico <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($inscripcion['email']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono <span class="required">*</span></label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                               value="<?php echo htmlspecialchars($inscripcion['telefono']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="genero" class="form-label">Género <span class="required">*</span></label>
                        <select class="form-select" id="genero" name="genero" required>
                            <option value="">Seleccione...</option>
                            <option value="Masculino" <?php echo ($inscripcion['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo ($inscripcion['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="localidad" class="form-label">Localidad <span class="required">*</span></label>
                        <select class="form-select" id="localidad" name="localidad" required>
                            <option value="">Seleccione...</option>
                            <option value="Juan Bautista Alberdi" <?php echo ($inscripcion['localidad'] == 'Juan Bautista Alberdi') ? 'selected' : ''; ?>>Juan Bautista Alberdi</option>
                            <option value="Graneros" <?php echo ($inscripcion['localidad'] == 'Graneros') ? 'selected' : ''; ?>>Graneros</option>
                            <option value="La Cocha" <?php echo ($inscripcion['localidad'] == 'La Cocha') ? 'selected' : ''; ?>>La Cocha</option>
                            <option value="Aguilares" <?php echo ($inscripcion['localidad'] == 'Aguilares') ? 'selected' : ''; ?>>Aguilares</option>
                            <option value="Concepción" <?php echo ($inscripcion['localidad'] == 'Concepción') ? 'selected' : ''; ?>>Concepción</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección <span class="required">*</span></label>
                    <input type="text" class="form-control" id="direccion" name="direccion" 
                           value="<?php echo htmlspecialchars($inscripcion['direccion']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="carrera_id" class="form-label">Carrera Deseada <span class="required">*</span></label>
                    <select class="form-select" id="carrera_id" name="carrera_id" required>
                        <option value="">Seleccione una carrera...</option>
                        <?php 
                        $carreras->data_seek(0); // Reiniciar el puntero
                        while ($carrera = $carreras->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $carrera['id']; ?>" 
                                    <?php echo ($inscripcion['carrera_id'] == $carrera['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($carrera['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="index.php" class="btn btn-secondary">
                         Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                         Actualizar Inscripción
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
closeConnection($conn);
?>
