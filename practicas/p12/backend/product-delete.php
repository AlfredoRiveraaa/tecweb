<?php
    use TECWEB\MYAPI\Delete\ProductsDelete;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new ProductsDelete('marketzone');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>