<?php
    include_once __DIR__.'/database.php';

    $id = $_GET['id'];

    // $query = "SELECT * FROM productos WHERE id = $id";
    $result = $conexion->query("SELECT * FROM productos WHERE id = $id");

    if(!$result){
        die('Query Error: '.mysqli_error($conexion));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'precio' => $row['precio'],
            'unidades' => $row['unidades'],
            'modelo' => $row['modelo'],
            'marca' => $row['marca'],
            'detalles' => $row['detalles'],
            'imagen' => $row['imagen']
        );
    }           
    // Codificar el array a JSON y devolverlo
    // echo json_encode($json, JSON_PRETTY_PRINT);
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>