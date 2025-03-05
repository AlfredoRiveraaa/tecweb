<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMATO JSON
$data = array();

// SI SE RECIBE UN ID, SE REALIZA UNA BÚSQUEDA ESPECÍFICA
if (isset($_POST['id'])) {
    $id = $conexion->real_escape_string($_POST['id']);

    $query = "SELECT * FROM productos WHERE id = '{$id}'";
    if ($result = $conexion->query($query)) {
        $row = $result->fetch_assoc();
        if ($row) {
            $data = $row;
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
}
// SI SE RECIBE UNA CONSULTA GENERAL (PARA BÚSQUEDA POR NOMBRE, MARCA O DETALLES)
elseif (isset($_POST['query'])) {
    $search = $conexion->real_escape_string($_POST['query']);

    $query = "SELECT * FROM productos 
              WHERE nombre LIKE '%{$search}%' 
                 OR marca LIKE '%{$search}%' 
                 OR detalles LIKE '%{$search}%'";
    
    if ($result = $conexion->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
}

$conexion->close();

// DEVOLVER LA RESPUESTA EN JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>
