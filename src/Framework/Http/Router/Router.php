<?php

namespace Framework\Http\Router;

use Framework\Http\Request;

class Router
{
    private $collection;

    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

    public function match(Request $request): Result
    {
        return $this->collection->match($request);
    }

    public function generate(string $name, array $params = []): string
    {
        
    }
}
