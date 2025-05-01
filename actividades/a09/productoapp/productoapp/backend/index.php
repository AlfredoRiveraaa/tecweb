<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use TECWEB\MYAPI\Create\ProductsCreate;
use TECWEB\MYAPI\Read\ProductsRead;
use TECWEB\MYAPI\Update\ProductsUpdate;
use TECWEB\MYAPI\Delete\ProductsDelete;

$app = AppFactory::create();
$app->setBasePath('/actividades/a09/productoapp/backend');

// Middleware to parse JSON body
$app->addBodyParsingMiddleware();

// Add error handling middleware
$app->addErrorMiddleware(true, true, true);

// Route to get a single product by ID
$app->get('/product/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $productos = new ProductsRead('marketzone');
    $productos->single($id);
    $response->getBody()->write(json_encode($productos->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// Route to get a list of all products
$app->get('/products', function ($request, $response) {
    $productos = new ProductsRead('marketzone');
    $productos->list();
    $response->getBody()->write(json_encode($productos->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// Route to search for products
$app->get('/products/{search}', function ($request, $response, $args) {
    $search = $args['search'];
    $productos = new ProductsRead('marketzone');
    $productos->search($search);
    $response->getBody()->write(json_encode($productos->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// Route to add a new product
$app->post('/product', function ($request, $response) {
    $data = $request->getParsedBody();
    $productos = new ProductsCreate('marketzone');
    $productos->add((object) $data);
    $response->getBody()->write(json_encode($productos->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// Route to edit an existing product
$app->put('/product/{id}', function ($request, $response, $args) {
    // $id = $args['id'];
    $body = $request->getBody()->getContents();
    $data = json_decode($body);
    $data->id = $args['id']; 

    $productos = new ProductsUpdate('marketzone');
    $productos->edit($data);

    $response->getBody()->write(json_encode($productos->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// Route to delete a product
$app->delete('/product/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $productos = new ProductsDelete('marketzone');
    $productos->delete($id);
    $response->getBody()->write(json_encode($productos->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

// Run the Slim app
$app->run();
