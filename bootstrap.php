<?php
require_once __DIR__.'/vendor/autoload.php';
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\RouteCollectionInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->addDefinitions(__DIR__.'/dependencies.php');

$container = $builder->build();


$request = $container->get(ServerRequestInterface::class);
$router = $container->get(RouteCollectionInterface::class);
$emitter = $container->get(EmitterInterface::class);

// map a route
$router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Laminas\Diactoros\Response;
    $response->getBody()->write('<h1>Hello, World!</h1>');
    return $response;
});

$response = $router->dispatch($request);
$emitter->emit($response);


