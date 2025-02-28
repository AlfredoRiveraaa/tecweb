<?php
/** SE CREA EL OBJETO DE CONEXIÓN */
@$link = new mysqli('localhost', 'root', 'eura12vl', 'marketzone');

/** Comprobar la conexión */
if ($link->connect_errno) {
    die('Falló la conexión: '.$link->connect_error.'<br/>');
}

/** Verificar si el formulario fue enviado */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $id = intval($_POST["id"]);
    $nombre = trim($_POST["nombre"]);
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $precio = floatval($_POST["precio"]);
    $detalles = trim($_POST["detalles"]);
    $unidades = intval($_POST["unidades"]);
    $imagen = trim($_POST["imagen"]);

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($marca) || empty($modelo) || empty($precio) || empty($detalles) || empty($unidades) || empty($imagen)) {
        die("<p>Error: Todos los campos son obligatorios.</p><a href='formulario_productos.html'>Volver al formulario</a>");
    }

    // Verificar si el producto existe en la base de datos
    $query = "SELECT COUNT(*) AS total FROM productos WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row["total"] == 0) {
        die("<p>Error: El producto con ID $id no existe en la base de datos.</p><a href='formulario_productos.html'>Volver al formulario</a>");
    }

    // Query de actualización
    $query = "UPDATE productos 
              SET nombre = ?, marca = ?, modelo = ?, precio = ?, detalles = ?, unidades = ?, imagen = ? 
              WHERE id = ?";

    // Preparar la consulta
    $stmt = $link->prepare($query);
    $stmt->bind_param("sssdsisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $id);

    if ($stmt->execute()) {
        echo "<h2>Producto actualizado con éxito</h2>";
        echo "<p><strong>ID:</strong> $id</p>";
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Marca:</strong> $marca</p>";
        echo "<p><strong>Modelo:</strong> $modelo</p>";
        echo "<p><strong>Precio:</strong> $$precio</p>";
        echo "<p><strong>Detalles:</strong> $detalles</p>";
        echo "<p><strong>Unidades disponibles:</strong> $unidades</p>";
        echo "<p><strong>Imagen:</strong> <img src='$imagen' width='100'></p>";
        echo "<a href='formulario_productos.html'>Actualizar otro producto</a>";
    } else {
        echo "<p>Error al actualizar el producto: " . $stmt->error . "</p>";
        echo "<a href='formulario_productos.html'>Volver al formulario</a>";
    }

    // Cerrar conexión
    $stmt->close();
    $link->close();
} else {
    echo "<p>Error: Acceso no válido.</p>";
}
?>
