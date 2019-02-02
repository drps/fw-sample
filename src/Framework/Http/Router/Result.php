<?php

namespace Framework\Http\Router;

class Result
{
    private $route;
    private $attributes;

    public function __construct(Route $route, array $attributes = [])
    {
        $this->route = $route;
        $this->attributes = $attributes;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
