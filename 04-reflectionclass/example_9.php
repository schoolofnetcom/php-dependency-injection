<?php

namespace MyNamespace {
    class Dependency
    {
        public function showMe()
        {
            return "class Dependency has be used";
        }
    }

    $class = new \ReflectionClass('MyNamespace\Dependency');
    $object = $class->newInstance();

    var_dump($object->showMe());
    var_dump($class->getMethods());
};
