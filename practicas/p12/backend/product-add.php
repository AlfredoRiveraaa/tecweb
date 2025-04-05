<?php
    use TECWEB\MYAPI\Create\ProductsCreate;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new ProductsCreate('marketzone');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>