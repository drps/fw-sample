<?php

namespace Framework\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private $definitions = [];
    private $instantiated = [];

    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->definitions);
    }

    public function set($name, callable $callable)
    {
        $this->definitions[$name] = $callable;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->instantiated)) {
            return $this->instantiated[$name];
        }

        if (!array_key_exists($name, $this->definitions)) {
            if (class_exists($name)) {
                $reflection = new \ReflectionClass($name);
                $arguments = [];
                if ($constructor = $reflection->getConstructor()) {
                    $params = $reflection->getConstructor()->getParameters();

                    /** @var \ReflectionParameter $param */
                    foreach ($params as $param) {
                        if($class = $param->getClass()) {
                            $arguments[] = $this->get($class->getName());
                        } elseif ($param->isArray()) {
                            $arguments[] = [];
                        } elseif (!$param->isDefaultValueAvailable()) {
                            throw new \Exception("Cannot instanciate {$name}: unknown parameter " . $param->getName());
                        } else {
                            $arguments[] = $param->getDefaultValue();
                        }
                    }
                }

                $this->instantiated[$name] = new $name(...$arguments);
                return $this->instantiated[$name];
            } else {
                throw new \Exception("Cannot instanciate {$name}: unknown class");
            }
        }

        $definition = $this->definitions[$name];
        if ($definition instanceof \Closure) {
            $this->instantiated[$name] = $definition($this);
        } else {
            $this->instantiated[$name] = $definition;
        }

        return $this->instantiated[$name];
    }
}
