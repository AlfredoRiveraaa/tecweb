<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validación básica de campos requeridos
    if(!isset($data['nombre']) || empty($data['nombre'])) {
        echo json_encode(array('status' => 'error', 'message' => 'El nombre es requerido'), JSON_PRETTY_PRINT);
        exit;
    }
    
    echo $prodObj->insert($data)->getData();
?>