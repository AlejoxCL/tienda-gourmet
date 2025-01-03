<?php
session_start();
require_once 'conexion.php';

// Recuperar datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Verificar si el usuario existe en la base de datos
$sql = "SELECT ID, nombre, email, contraseña FROM USUARIOS WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
  $usuario = $resultado->fetch_assoc();
  // Verificar la contraseña
  if (password_verify($password, $usuario['contraseña'])) {
    // Contraseña correcta, iniciar sesión
    $_SESSION['usuario_id'] = $usuario['ID'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    header("Location: index.html");
  } else {
    echo "Contraseña incorrecta";
  }
} else {
  echo "No existe un usuario con ese correo.";
}

$stmt->close();
$conn->close();
?>
