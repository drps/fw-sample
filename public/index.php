<?php

use Framework\Container\Container;
use Framework\Http\Application;
use Framework\Http\Emitter;
use Framework\Http\Request;
use Framework\Http\Response;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = new Container(require 'config/container.php');
/** @var Application $app */
$app = $container->get(Application::class);
require 'config/routes.php';

$request = new Request();

try {
    $routeResult = $app->match($request);
    $attributes = $routeResult->getAttributes();
    foreach ($attributes as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handler = $container->get($routeResult->getRoute()->getHandler());
    $response = $handler($request);
} catch (\Exception|Throwable $e) {
    $response = new Response($e->getMessage(), 400);
}

$emitter = new Emitter();
$emitter->emit($response);
