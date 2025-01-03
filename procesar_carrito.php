<?php
session_start();
if(!isset($_SESSION['usuario_id'])){
  header("Location: login.html");
  exit();
}

require_once 'conexion.php';

$usuarioId   = $_SESSION['usuario_id'];
$productoId  = $_POST['producto_id'];
$cantidad    = $_POST['cantidad'];

// Primero consultamos el precio del producto
$sqlPrecio = "SELECT precio FROM PRODUCTOS WHERE ID = ?";
$stmtPrecio = $conn->prepare($sqlPrecio);
$stmtPrecio->bind_param("i", $productoId);
$stmtPrecio->execute();
$resultPrecio = $stmtPrecio->get_result();
$precioProducto = 0;

if($resultPrecio->num_rows > 0){
  $fila = $resultPrecio->fetch_assoc();
  $precioProducto = $fila['precio'];
}
$stmtPrecio->close();

// Calcular monto total
$montoTotal = $precioProducto * $cantidad;

// Insertar registro en la tabla CARRITO
$sqlInsert = "INSERT INTO CARRITO (usuario_id, producto_id, cantidad, monto_total) 
              VALUES (?, ?, ?, ?)";
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bind_param("iiid", $usuarioId, $productoId, $cantidad, $montoTotal);

if($stmtInsert->execute()){
  header("Location: carrito.php");
} else {
  echo "Error al agregar al carrito: " . $stmtInsert->error;
}

$stmtInsert->close();
$conn->close();
?>
