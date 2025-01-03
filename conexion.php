<?php
$servername = "localhost";  // o el host que corresponda
$username = "root";         // usuario de la BD
$password = "root";             // contraseña de la BD
$dbname = "GOURMET";        // nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Opcional: establecer set names UTF8 si se quiere para acentos, etc.
// $conn->set_charset("utf8");
?>
