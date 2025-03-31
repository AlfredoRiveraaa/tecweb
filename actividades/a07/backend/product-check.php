<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    $nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';
    
    if(empty($nombre)) {
        echo json_encode(
            array('error' => true, 'message' => 'El nombre del producto no puede estar vacío'),
            JSON_PRETTY_PRINT
        );
        exit;
    }
    
    echo $prodObj->checkName($nombre)->getData();
?>