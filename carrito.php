<?php
session_start();
if(!isset($_SESSION['usuario_id'])){
  // Si no hay sesión iniciada, redirigir al login
  header("Location: login.html");
  exit();
}
require_once 'conexion.php';

// Obtén la lista de productos para el select
$sqlProductos = "SELECT ID, nombre, precio FROM PRODUCTOS";
$resultProductos = $conn->query($sqlProductos);

// Procesar acción de eliminar del carrito (parámetro GET)
if(isset($_GET['eliminar'])){
  $idCarrito = $_GET['eliminar'];
  $sqlEliminar = "DELETE FROM CARRITO WHERE ID = ?";
  $stmtEliminar = $conn->prepare($sqlEliminar);
  $stmtEliminar->bind_param("i", $idCarrito);
  $stmtEliminar->execute();
  $stmtEliminar->close();
}

// Consultar el carrito actual del usuario
$usuarioId = $_SESSION['usuario_id'];
$sqlCarrito = "SELECT CARRITO.ID, PRODUCTOS.nombre, CARRITO.cantidad, CARRITO.monto_total 
               FROM CARRITO 
               JOIN PRODUCTOS ON CARRITO.producto_id = PRODUCTOS.ID 
               WHERE CARRITO.usuario_id = ?";
$stmtCarrito = $conn->prepare($sqlCarrito);
$stmtCarrito->bind_param("i", $usuarioId);
$stmtCarrito->execute();
$resultCarrito = $stmtCarrito->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  />
</head>
<body class="bg-light">
  <div class="container my-5">
    <h2 class="text-center">Carrito de Compras</h2>

    <!-- Formulario para agregar o modificar productos en el carrito -->
    <form action="procesar_carrito.php" method="POST" class="row g-3">
      <div class="col-md-4">
        <label for="producto_id" class="form-label">Producto:</label>
        <select name="producto_id" id="producto_id" class="form-select" required>
          <option value="">Selecciona un producto</option>
          <?php while($producto = $resultProductos->fetch_assoc()){ ?>
            <option value="<?php echo $producto['ID']; ?>">
              <?php echo $producto['nombre']; ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-4">
        <label for="cantidad" class="form-label">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
      </div>
      <div class="col-md-4 d-grid">
        <button type="submit" class="btn btn-primary mt-4">Agregar al Carrito</button>
      </div>
    </form>

    <hr/>

    <!-- Mostrar el carrito actual del usuario -->
    <h3>Productos en tu carrito</h3>
    <table class="table table-bordered table-striped mt-3">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Monto Total</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while($carrito = $resultCarrito->fetch_assoc()){ ?>
          <tr>
            <td><?php echo $carrito['nombre']; ?></td>
            <td><?php echo $carrito['cantidad']; ?></td>
            <td>$<?php echo number_format($carrito['monto_total'], 2); ?></td>
            <td>
              <a 
                href="carrito.php?eliminar=<?php echo $carrito['ID']; ?>" 
                class="btn btn-danger btn-sm"
              >Eliminar</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$stmtCarrito->close();
$conn->close();
?>
