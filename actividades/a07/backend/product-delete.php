<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    $id = isset($_POST['id']) ? $_POST['id'] : die();
    
    echo $prodObj->delete($id)->getData();
?>