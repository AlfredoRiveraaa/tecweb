<?php
    // Incluir el archivo de configuración de la base de datos
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);

        // Verificamos si el producto ya existe
        $sql = "SELECT id FROM productos 
                WHERE (nombre = ? AND marca = ? OR marca = ? AND modelo = ?) 
                AND eliminado = 0";

        // Preparamos la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $jsonOBJ->nombre, $jsonOBJ->marca, $jsonOBJ->marca, $jsonOBJ->modelo);

        // Ejecutamos la consulta
        $stmt->execute();
        $stmt->store_result();

        // Si el producto ya existe, devolvemos un mensaje de error
        if ($stmt->num_rows > 0) {
            echo json_encode(["mensaje" => "Error: El producto ya existe."]);
        } else {
            // Si no existe, realizamos la inserción del producto
            $sqlInsert = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagen)
                          VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Preparamos la consulta para insertar
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->bind_param("sssdiss", 
                $jsonOBJ->nombre, 
                $jsonOBJ->marca, 
                $jsonOBJ->modelo, 
                $jsonOBJ->precio, 
                $jsonOBJ->unidades, 
                $jsonOBJ->detalles, 
                $jsonOBJ->imagen
            );

            // Ejecutamos la inserción
            if ($stmtInsert->execute()) {
                echo json_encode(["mensaje" => "Producto insertado con éxito."]);
            } else {
                echo json_encode(["mensaje" => "Error al insertar el producto."]);
            }

            // Cerramos la consulta de inserción
            $stmtInsert->close();
        }

        // Cerramos la consulta de búsqueda
        $stmt->close();

        // Cerramos la conexión a la base de datos
        $conexion->close();
    } else {
        echo json_encode(["mensaje" => "No se recibieron datos."]);
    }
?>
