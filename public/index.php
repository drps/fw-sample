<?php

use Framework\Http\Emitter;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$routes = new RouteCollection();

$routes->get('/', function (Request $request) {
    return new Response("<a href='/blog/24?name=sasa'>Blog/24</a>");
}, 'home');

$routes->get('/blog/{id}', function (Request $request) {
    $name = $request->getQueryParams()['name'] ?? 'ooops';
    $name = $request->getAttribute('id') ?: 'sss';
    return new Response("Hello, {$name}!", 200);
});

$request = new Request();
$router = new Router($routes);

try {
    $routeResult = $router->match($request);
    $attributes = $routeResult->getAttributes();
    foreach ($attributes as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $response = ($routeResult->getRoute()->getHandler())($request);
} catch (\Exception|Throwable $e) {
    $response = new Response($e->getMessage(), 400);
}

$emitter = new Emitter();
$emitter->emit($response);
