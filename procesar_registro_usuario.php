<?php
// Conexión a la base de datos
require_once 'conexion.php'; // archivo con la conexión (ver ejemplo más abajo)

// Recuperar datos del formulario
$nombre    = $_POST['nombre'];
$email     = $_POST['email'];
$password  = $_POST['password'];
$direccion = $_POST['direccion'];
$telefono  = $_POST['telefono'];

// Importante: aplicar medidas de seguridad en la contraseña (hash, etc.)
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Preparar la sentencia SQL
$sql = "INSERT INTO USUARIOS (nombre, email, contraseña, direccion, telefono) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $email, $passwordHash, $direccion, $telefono);

if($stmt->execute()){
  echo "Registro de usuario exitoso. <a href='login.html'>Iniciar Sesión</a>";
} else {
  echo "Error al registrar usuario: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
