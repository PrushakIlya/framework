<?php

namespace Prushak\Framework\Container;

use Prushak\Framework\Container\Psr\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function add(string $id, mixed $concrete = null): self
    {
        if (null === $concrete) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be added");
            }

            $concrete = $id;
        }

        $this->services[$id] = $concrete;

        return $this;
    }

    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                return $this->services[$id];
            }

            $this->add($id);
        }

        if (is_object($this->services[$id])) {
            return $this->services[$id];
        }

        return $this->resolve($this->services[$id]);
    }

    private function resolve(string|array $class): mixed
    {
        try {
            $reflectionClass = new \ReflectionClass($class);
        } catch (\Throwable $e) {
            return $class;
        }

        $constructor = $reflectionClass->getConstructor();

        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        $constructorParams = $constructor->getParameters();



        $classDependencies = $this->resolveClassDependencies($constructorParams);

        return $reflectionClass->newInstanceArgs($classDependencies);
    }

    private function resolveClassDependencies(array $reflectionParameters): array
    {
        $classDependencies = [];

        foreach ($reflectionParameters as $parameter) {
            $serviceType = $parameter->getType();

            $service = $this->get($serviceType->getName());

            $classDependencies[] = $service;
        }

        return $classDependencies;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}