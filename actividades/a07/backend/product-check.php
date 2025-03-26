<?php
// Incluir la conexión a la base de datos
include_once __DIR__.'/database.php';

// Obtener el nombre del producto desde la solicitud GET
$nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';

// Verificar si el nombre no está vacío
if (empty($nombre)) {
    // Si el nombre está vacío, devolver un error
    $response = array(
        'error' => true,
        'message' => 'El nombre del producto no puede estar vacío.'
    );
    echo json_encode($response);
    exit; // Detener la ejecución del script
}

// Preparar la consulta SQL para verificar si el nombre ya existe
$query = "SELECT * FROM productos WHERE nombre LIKE '%$nombre%'";
$result = mysqli_query($conn, $query);

// Verificar si hubo un error en la consulta
if (!$result) {
    // Si hay un error en la consulta, devolver un mensaje de error
    $response = array(
        'error' => true,
        'message' => 'Error al realizar la consulta en la base de datos.'
    );
    echo json_encode($response);
    exit; // Detener la ejecución del script
}

// Obtener las coincidencias de nombres
$coincidencias = array();
while ($row = mysqli_fetch_assoc($result)) {
    $coincidencias[] = $row['nombre'];
}

// Verificar si se encontraron coincidencias
if (count($coincidencias) > 0) {
    // Si hay coincidencias, devolver la lista de nombres coincidentes
    $response = array(
        'exists' => true,
        'coincidencias' => $coincidencias,
        'message' => 'Se encontraron coincidencias.'
    );
} else {
    // Si no hay coincidencias, el nombre no existe
    $response = array(
        'exists' => false,
        'message' => 'No se encontraron coincidencias.'
    );
}

// Devolver la respuesta en formato JSON
echo json_encode($response);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>