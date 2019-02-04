<?php

namespace Framework\Http;

use Framework\Http\Router\Result;
use Framework\Http\Router\Route;
use Framework\Http\Router\Router;

class Application
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function get(string $path, $handler, string $name = '')
    {
        $this->router->addRoute(new Route($path, 'get', $handler, $name));
    }

    public function post(string $path, $handler, string $name = null)
    {
        $this->router->addRoute(new Route($path, 'post', $handler, $name));
    }

    public function match(Request $request): Result
    {
        return $this->router->match($request);
    }
}
