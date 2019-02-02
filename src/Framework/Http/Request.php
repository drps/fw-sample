<?php

namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBodyParams;
    private $server;
    private $attributes = [];

    public function __construct($queryParams = null, $parsedBodyParams = [], $server = null)
    {
        $this->queryParams = $queryParams ?: $_GET;
        $this->parsedBodyParams = $parsedBodyParams ?: $_POST;
        $this->server = $server ?: $_SERVER;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getParsedBodyParams(): array
    {
        return $this->parsedBodyParams;
    }

    public function getPath()
    {
        $requestUri = array_key_exists('REQUEST_URI', $this->server) ? $this->server['REQUEST_URI'] : null;

        return explode('?', $requestUri, 2)[0];
    }

    public function withAttribute($name, $value)
    {
        $new = clone $this;
        $new->attributes[$name] = $value;
        return $new;
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function getMethod()
    {
        $method = $this->server['REQUEST_METHOD'] ?? 'get';
        return \strtolower($method);
    }
}
