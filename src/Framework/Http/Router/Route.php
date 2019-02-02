<?php

namespace Framework\Http\Router;

use Framework\Http\Request;

class Route
{
    private $path;
    private $method;
    private $handler;
    private $name;
    private $pattern;

    public function __construct(string $path, string $method, callable $handler, string $name)
    {
        if (preg_match_all('#{(.*?)}#', $path, $matches)) {
            $replaces = array_combine(
                array_map(function ($item) {
                    return $item;
                }, $matches[0]),
                array_map(function ($item) {
                    return "(?P<{$item}>\w+)";
                }, $matches[1])
            );

            $this->pattern = strtr($path, $replaces);
        }

        $this->path = $path;
        $this->method = $method;
        $this->handler = $handler;
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandler(): callable
    {
        return $this->handler;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function match(Request $request): ?Result
    {
        if ($this->method && $this->method !== $request->getMethod()) {
            return null;
        }

        $path = $request->getPath();
        $pattern = $this->pattern ?: $this->path;

        if (preg_match(
            '#^' . $pattern . '$#',
            $path,
            $matches
        )) {

            $attributes = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return new Result($this, $attributes);
        }

        return null;
    }
}
