<?php
$contrasena_plana = 'admin'; // La contraseña que usarás para hacer login
$hash_generado = password_hash($contrasena_plana, PASSWORD_DEFAULT);

echo "Contraseña plana a usar: " . $contrasena_plana . "<br>";
echo "Nuevo Hash generado: " . $hash_generado . "<br>";
?>