<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    
    // Cambiamos a recibir datos de $_POST en lugar de php://input
    $data = $_POST;
    
    echo $prodObj->update($data['id'], $data)->getData();
?>