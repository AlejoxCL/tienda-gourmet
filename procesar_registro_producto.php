<?php
// Conexión a la base de datos
require_once 'conexion.php';

// Recuperar datos del formulario
$nombreProducto = $_POST['nombreProducto'];
$descripcion    = $_POST['descripcion'];
$categoria      = $_POST['categoria'];
$precio         = $_POST['precio'];
$cantidad       = $_POST['cantidad'];

// Preparar la sentencia SQL
$sql = "INSERT INTO PRODUCTOS (nombre, descripcion, categoria, precio, cantidad) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssdi", $nombreProducto, $descripcion, $categoria, $precio, $cantidad);

if($stmt->execute()){
  echo "Producto registrado con éxito. <a href='index.html'>Volver al inicio</a>";
} else {
  echo "Error al registrar producto: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
