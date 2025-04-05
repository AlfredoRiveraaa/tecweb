<?php
    use TECWEB\MYAPI\Read\ProductsRead;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new ProductsRead('marketzone');
    $productos->single( $_POST['id'] );
    echo $productos->getData();
?>