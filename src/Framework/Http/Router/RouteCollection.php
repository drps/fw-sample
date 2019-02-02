<?php

namespace Framework\Http\Router;

use Framework\Http\Request;

class RouteCollection
{
    /** @var Route[] */
    private $routes = [];

    public function any(string $path, callable $handler, string $name = null)
    {
        $this->addRoute(new Route($path, null, $handler, $name));
    }

    public function get(string $path, callable $handler, string $name = '')
    {
        $this->addRoute(new Route($path, 'get', $handler, $name));
    }

    public function post(string $path, callable $handler, string $name = null)
    {
        $this->addRoute(new Route($path, 'post', $handler, $name));
    }

    public function match(Request $request): Result
    {
        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new RouteNotFoundException('Route not found');
    }

    private function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }
}
