<?php

include 'includes/conect.php';

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$dni = $_POST["dni"];
$genero = $_POST["genero"];
$localidad = $_POST["localidad"];
$direccion = $_POST["direccion"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$carrera = $_POST["carrera"];

$errores = [];
foreach (['nombre','apellido','dni','genero','localidad','direccion','email','carrera'] as $c) {
  if ($$c === '') $errores[] = "Campo $c es obligatorio";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email inválido";

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


$stmt->close();
$conn->close();


header("Location: /PROYECTOFINAL/preinscripcion.php");
exit;


?>
?>