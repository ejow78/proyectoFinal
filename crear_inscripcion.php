<?php
session_start();
require 'conect.php';

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
    <style>
        /* Estilos mejorados para el formulario */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .form-header h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
        }
        
        .form-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .form-select {
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .required {
            color: #dc3545;
        }
        
        .btn-group-custom {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn-custom {
            flex: 1;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary-custom {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary-custom:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h3>Nueva Inscripción</h3>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Complete el formulario para registrar una nueva inscripción</p>
        </div>
        
        <div class="form-body">
            <form action="crear_inscripcion.php" method="POST">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="nombre" class="form-label">Nombre <span class="required">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="apellido" class="form-label">Apellido <span class="required">*</span></label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="dni" class="form-label">DNI <span class="required">*</span></label>
                        <input type="number" class="form-control" id="dni" name="dni" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="genero" class="form-label">Género <span class="required">*</span></label>
                        <select class="form-select" id="genero" name="genero" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                            <option value="otro">Otro/a</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
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
                    <div class="col-md-6 form-group">
                        <label for="direccion" class="form-label">Dirección <span class="required">*</span></label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6 form-group">
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

                <div class="btn-group-custom">
                    <a href="paneldecontrol.php" class="btn-custom btn-secondary-custom" style="text-decoration: none; text-align: center; line-height: 1.5;">Cancelar</a>
                    <button type="submit" class="btn-custom btn-primary-custom">Guardar Inscripción</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
