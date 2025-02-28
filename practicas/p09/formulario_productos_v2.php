<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Productos</title>
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
    <h2>Registro de Producto</h2>
    <form action="set_producto_v2.php" method="post" onsubmit="return validarFormulario()">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>" required>

        <label for="marca">Marca:</label>
        <select id="marca" name="marca" required>
            <option value="">Seleccione una marca</option>
            <option value="Samsung" <?= isset($_POST['marca']) && $_POST['marca'] == 'Samsung' ? 'selected' : '' ?>>Samsung</option>
            <option value="Apple" <?= isset($_POST['marca']) && $_POST['marca'] == 'Apple' ? 'selected' : '' ?>>Apple</option>
            <option value="Sony" <?= isset($_POST['marca']) && $_POST['marca'] == 'Sony' ? 'selected' : '' ?>>Sony</option>
            <option value="Xiaomi" <?= isset($_POST['marca']) && $_POST['marca'] == 'Xiaomi' ? 'selected' : '' ?>>Xiaomi</option>
        </select>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="<?= isset($_POST['modelo']) ? $_POST['modelo'] : '' ?>" required>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?= isset($_POST['precio']) ? $_POST['precio'] : '' ?>" required>

        <label for="detalles">Detalles:</label>
        <textarea id="detalles" name="detalles" rows="3"><?= isset($_POST['detalles']) ? $_POST['detalles'] : '' ?></textarea>

        <label for="unidades">Unidades:</label>
        <input type="number" id="unidades" name="unidades" min="0" value="<?= isset($_POST['unidades']) ? $_POST['unidades'] : '' ?>" required>

        <label for="imagen">URL de Imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?= isset($_POST['imagen']) ? $_POST['imagen'] : '' ?>">

        <button type="submit">Registrar Producto</button>
    </form>
</body>
</html>
