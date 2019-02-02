<?php

namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBodyParams;

    public function __construct($queryParams = null, $parsedBodyParams = [])
    {
        $this->queryParams = $queryParams ?: $_GET;
        $this->parsedBodyParams = $parsedBodyParams ?: $_POST;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getParsedBodyParams(): array
    {
        return $this->parsedBodyParams;
    }
}
