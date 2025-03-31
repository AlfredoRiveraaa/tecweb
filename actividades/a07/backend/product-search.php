<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    $search = isset($_GET['search']) ? $_GET['search'] : die();
    
    echo $prodObj->search($search)->getData();
?>