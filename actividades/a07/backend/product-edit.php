<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(!isset($data['id'])) {
        echo json_encode(array('status' => 'error', 'message' => 'ID es requerido'), JSON_PRETTY_PRINT);
        exit;
    }
    
    echo $prodObj->update($data['id'], $data)->getData();
?>