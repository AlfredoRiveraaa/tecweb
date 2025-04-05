<?php
    use TECWEB\MYAPI\Update\ProductsUpdate;
    require_once __DIR__.'/../vendor/autoload.php';

    $productos = new ProductsUpdate('marketzone');
    $productos->edit( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>