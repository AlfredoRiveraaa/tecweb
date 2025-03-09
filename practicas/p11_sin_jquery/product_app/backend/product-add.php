<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
$data = array(
    'status'  => 'error',
    'message' => 'Error al procesar la solicitud'
);

if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // VALIDACIONES EN EL BACKEND
    if (empty($jsonOBJ->nombre) || strlen($jsonOBJ->nombre) > 100) {
        $data['message'] = 'El nombre es obligatorio y debe tener 100 caracteres o menos.';
    } elseif (empty($jsonOBJ->marca)) {
        $data['message'] = 'Debe seleccionar una marca.';
    } elseif (empty($jsonOBJ->modelo) || strlen($jsonOBJ->modelo) > 25 || !preg_match('/^[a-zA-Z0-9 ]+$/', $jsonOBJ->modelo)) {
        $data['message'] = 'El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos.';
    } elseif (!is_numeric($jsonOBJ->precio) || $jsonOBJ->precio <= 99.99) {
        $data['message'] = 'El precio es obligatorio y debe ser mayor a 99.99.';
    } elseif (strlen($jsonOBJ->detalles) > 250) {
        $data['message'] = 'Los detalles deben tener 250 caracteres o menos.';
    } elseif (!is_numeric($jsonOBJ->unidades) || $jsonOBJ->unidades < 0) {
        $data['message'] = 'Las unidades deben ser un número mayor o igual a 0.';
    } else {
        // SE VERIFICA SI YA EXISTE UN PRODUCTO CON EL MISMO NOMBRE Y NO ESTÁ ELIMINADO
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
        $result = $conexion->query($sql);

        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if ($conexion->query($sql)) {
                $data['status'] = "success";
                $data['message'] = "Producto agregado correctamente.";
            } else {
                $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
            }
        } else {
            $data['message'] = "Ya existe un producto con ese nombre.";
        }

        $result->free();
    }

    // Cierra la conexión
    $conexion->close();
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>