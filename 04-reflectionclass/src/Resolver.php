<?php

namespace SON\Di;

class Resolver
{
    private $dependencies_inject;

    public function resolveFunction($fn, $dependencies_inject=[])
    {
        if ($dependencies_inject !== []) {
            $this->dependencies_inject = $dependencies_inject;
        }

        $info = new \ReflectionFunction($fn);
        $parameters = $info->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return call_user_func_array($info->getClosure(), $dependencies);
    }

    public function resolveClass($class, $dependencies_inject = [])
    {
        if ($dependencies_inject !== []) {
            $this->dependencies_inject = $dependencies_inject;
        }

        if (is_string($class)) {
            $class = new \ReflectionClass($class);
        }

        if (!$class->isInstantiable()) {
            throw new \Exception("{$class->name} is not instantiable");
        }

        $constructor = $class->getConstructor();

        if (is_null($constructor)) {
            return new $class->name;
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);
        return $class->newInstanceArgs($dependencies);
    }

    protected function getDependencies($parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->resolveClass($dependency);
            }
        }

        return $dependencies;
    }

    protected function resolveNonClass(\ReflectionParameter $parameter)
    {
        if (isset($this->dependencies_inject[$parameter->name])) {
            return $this->dependencies_inject[$parameter->name];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new \Exception("Cannot resolve the unknow!?");
    }
}
