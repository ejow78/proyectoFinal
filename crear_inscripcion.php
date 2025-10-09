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
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Nueva Inscripción</h3>
                    </div>
 
                        <form class="registroform-form" id="registroform" action="crear_inscripcion.php" method="POST">
  
          <div class="form-row">
            <div class="form-group">
              <label for="nombre">Nombre *</label>
              <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
              <label for="apellido">Apellido *</label>
              <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
              <label for="dni">DNI *</label>
              <input type="number" id="dni" name="dni" required>
            </div>
            <div class="form-group">
              <label for="genero">Género *</label>
              <select id="genero" name="genero" required>
                <option value="" disabled selected hidden>Selecciona una opción</option>
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>
                <option value="otrog">Otro/a</option>
              </select>
            </div>
          </div>


          <div class="form-row">
            <div class="form-group full">
              <label for="localidad">Localidad *</label>
              <select id="localidad" name="localidad" required>
                <option value="" disabled selected hidden>Selecciona una opción</option>
                <option value="alberdi">Alberdi</option>
                <option value="aguilares">Aguilares</option>
                <option value="concepcion">Concepcion</option>
                <option value="graneros">Graneros</option>
                <option value="lacocha">La Cocha</option>
                <option value="lamadrid">La Madrid</option>
                <option value="santana">Santa Ana</option>
                <option value="villabel">Villa Belgrano</option>
                <option value="otraloc">Otro/a</option>
              </select>
            </div>
            <div class="form-group">
              <label for="direccion">Dirección *</label>
              <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
              <label for="email">Email *</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <input type="tel" id="telefono" name="telefono" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group full">
              <label for="carrera">Carrera *</label>
              <select id="carrera" name="carrera" required>
                <option value="" disabled selected hidden>Selecciona una opción</option>
                <option value="alimentos">Técnico Superior en Agroindustria de los Alimentos</option>
                <option value="historia">Profesorado de Educación Secundaria en Historia</option>
                <option value="matematicas">Profesorado de Educación Secundaria en Matemáticas</option>
                <option value="agropecuaria">Técnico Superior en Gestión de Producción Agropecuaria</option>
                <option value="software">Técnico Superior en Desarrollo de Software</option>
                <option value="otro">Otro</option>
              </select>
            </div>

    

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="paneldecontrol.php" class="btn btn-secondary">Cancelar</a>
        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

