<?php
// Conexión a la base de datos
$link = mysqli_connect("localhost", "root", "eura12vl", "marketzone");
// Chequea la conexión
if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Si el ID del producto está presente en la URL, obtenemos los datos del producto
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;
$product_data = [];
if ($product_id) {
    $sql = "SELECT * FROM productos WHERE id = $product_id";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $product_data = mysqli_fetch_assoc($result);
    }
}

// Cierra la conexión
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            padding: 20px;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function validarFormulario() {
            let nombre = document.getElementById("nombre").value.trim();
            let marca = document.getElementById("marca").value;
            let modelo = document.getElementById("modelo").value.trim();
            let precio = parseFloat(document.getElementById("precio").value);
            let detalles = document.getElementById("detalles").value.trim();
            let unidades = parseInt(document.getElementById("unidades").value);
            let imagen = document.getElementById("imagen").value.trim();
            let imagenPorDefecto = "img/default.png";
            
            if (nombre === "" || nombre.length > 100) {
                alert("El nombre es obligatorio y debe tener 100 caracteres o menos.");
                return false;
            }
            
            if (marca === "") {
                alert("Debe seleccionar una marca.");
                return false;
            }
            
            if (modelo === "" || modelo.length > 25 || !/^[a-zA-Z0-9 ]+$/.test(modelo)) {
                alert("El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos.");
                return false;
            }
            
            if (isNaN(precio) || precio <= 99.99) {
                alert("El precio es obligatorio y debe ser mayor a 99.99.");
                return false;
            }
            
            if (detalles.length > 250) {
                alert("Los detalles deben tener 250 caracteres o menos.");
                return false;
            }
            
            if (isNaN(unidades) || unidades < 0) {
                alert("Las unidades deben ser un número mayor o igual a 0.");
                return false;
            }
            
            if (imagen === "") {
                document.getElementById("imagen").value = imagenPorDefecto;
            }
            
            return true;
        }
    </script>
</head>
<body>
    <h2>Actualizar Producto</h2>
    <?php if ($product_data): ?>
    <form action="update_producto.php" method="post" onsubmit="return validarFormulario()">
        <input type="hidden" name="id" value="<?= $product_data['id'] ?>">

        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $product_data['nombre'] ?>" required>

        <label for="marca">Marca:</label>
        <select id="marca" name="marca" required>
            <option value="">Seleccione una marca</option>
            <option value="Samsung" <?= $product_data['marca'] == 'Samsung' ? 'selected' : '' ?>>Samsung</option>
            <option value="Apple" <?= $product_data['marca'] == 'Apple' ? 'selected' : '' ?>>Apple</option>
            <option value="Sony" <?= $product_data['marca'] == 'Sony' ? 'selected' : '' ?>>Sony</option>
            <option value="Xiaomi" <?= $product_data['marca'] == 'Xiaomi' ? 'selected' : '' ?>>Xiaomi</option>
        </select>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="<?= $product_data['modelo'] ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?= $product_data['precio'] ?>" required>

        <label for="detalles">Detalles:</label>
        <textarea id="detalles" name="detalles" rows="3"><?= $product_data['detalles'] ?></textarea>

        <label for="unidades">Unidades:</label>
        <input type="number" id="unidades" name="unidades" min="0" value="<?= $product_data['unidades'] ?>" required>

        <label for="imagen">URL de Imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?= $product_data['imagen'] ?>">

        <button type="submit">Actualizar Producto</button>
    </form>
    <?php else: ?>
        <p>Producto no encontrado.</p>
    <?php endif; ?>

    <p><a href="get_productos_xhtml_v2.php">Ver todos los productos</a> | <a href="get_productos_vigentes_v2.php">Ver productos vigentes</a></p>
</body>
</html>
