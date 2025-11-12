<?php
session_start();
require __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO preinscripciones
      (nombre, apellido, dni, genero, localidad, direccion, email, telefono, carrera)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
      "sssssssss",
      $_POST['nombre'],
      $_POST['apellido'],
      $_POST['dni'],
      $_POST['genero'],
      $_POST['localidad'],
      $_POST['direccion'],
      $_POST['email'],
      $_POST['telefono'],
      $_POST['carrera']
    );
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: paneldecontrol.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Inscripción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Reemplazando estilos inline por link a stylespanel.css -->
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>stylespanel.css">
</head>
<body>
    <!-- Usando clases del CSS externo en lugar de estilos inline -->
    <div class="edit-page-container">
        <div class="edit-card">
            <div class="edit-card-header">
                <h2>Nueva Inscripción</h2>
                <p>Complete el formulario para registrar una nueva inscripción</p>
            </div>
            
            <div class="edit-card-body">
                <form action="crear_inscripcion.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre <span class="required">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="form-label">Apellido <span class="required">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="dni" class="form-label">DNI <span class="required">*</span></label>
                            <input type="number" class="form-control" id="dni" name="dni" required>
                        </div>
                        <div class="form-group">
                            <label for="genero" class="form-label">Género <span class="required">*</span></label>
                            <select class="form-select" id="genero" name="genero" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="otro">Otro/a</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="localidad" class="form-label">Localidad <span class="required">*</span></label>
                            <select class="form-select" id="localidad" name="localidad" required>
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="alberdi">Juan Bautista Alberdi</option>
                                <option value="aguilares">Aguilares</option>
                                <option value="concepcion">Concepción</option>
                                <option value="graneros">Graneros</option>
                                <option value="lacocha">La Cocha</option>
                                <option value="lamadrid">La Madrid</option>
                                <option value="santana">Santa Ana</option>
                                <option value="villabel">Villa Belgrano</option>
                                <option value="otraloc">Otro/a</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="form-label">Dirección <span class="required">*</span></label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono <span class="required">*</span></label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="carrera" class="form-label">Carrera <span class="required">*</span></label>
                        <select class="form-select" id="carrera" name="carrera" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="alimentos">Técnico Superior en Agroindustria de los Alimentos</option>
                            <option value="historia">Profesorado de Educación Secundaria en Historia</option>
                            <option value="matematicas">Profesorado de Educación Secundaria en Matemáticas</option>
                            <option value="agropecuaria">Técnico Superior en Gestión de Producción Agropecuaria</option>
                            <option value="software">Técnico Superior en Desarrollo de Software</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <a href="paneldecontrol.php" class="btn btn-cancel">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Inscripción</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
