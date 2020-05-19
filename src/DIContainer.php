<?php


namespace Rozeo\Support;


use Closure;

class DIContainer
{
    /**
     * @var array
     */
    private array $container;

    public function __construct()
    {
        $this->container = [];
    }

    public function bind(string $from, $to): self
    {
        if (!array_key_exists($from, $this->container)) {
            $this->container[$from] = $to;
        }
        return $this;
    }

    public function resolve(string $from)
    {
        $to = '';
        if (array_key_exists($from, $this->container)) {
            $to = $this->container[$from];
        } elseif (class_exists($from)) {
            $to = $from;
        } else {
            throw new \LogicException('Not found in container.');
        }

        if ($to instanceof Closure) {
            return call_user_func($to);
        }

        if (class_exists($to)) {
            $ref = new \ReflectionClass($to);
            $params = $ref->getMethod('__construct')->getParameters();
            foreach ($params as $index => $param) {
                $params[$index] = $this->resolve((string)$param->getType());
            }
            return new $to(...$params);
        }
    }
}