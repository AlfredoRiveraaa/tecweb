<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;

    require 'vendor/autoload.php';

    $app = AppFactory::create();
    $app->setBasepath("/tecweb/practicas/p17/slim_v4");

    $app->get('/', function (Request $request, Response $response){
        $response->getBody()->write("Hello World Slim!!!");
        return $response;
    })->setName('root');

    $app->get('/hola[/{nombre}]', function(Request $request, Response $response, $args){
        $response->getBody()->write('Hola, ' . $args["nombre"]);
        return $response;
    })->setName('root');

    $app->post('/pruebapost', function(Request $request, Response $response, $args){
        $reqPost = $request->getParsedBody();
        $val1 = $reqPost["val1"];
        $val2 = $reqPost["val2"];

        $response->getBody()->write("Valores: ".$val1." ".$val2);
        return $response;
    });

    $app->post('/testjson', function(Request $request, Response $response, $args){
        $reqPost = $request->getParsedBody();
        $data[0]['nombre']    = $reqPost["nombre1"];
        $data[0]['apellidos'] = $reqPost["apellido1"];
        $data[1]['nombre']    = $reqPost["nombre2"];
        $data[1]['apellidos'] = $reqPost["apellido2"];

        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response;
    });
    
    $app->run();
?>