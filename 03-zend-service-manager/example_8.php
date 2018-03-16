<?php

require __DIR__.'/../vendor/autoload.php';

use Zend\ServiceManager\ServiceManager;

$serviceManager = new ServiceManager([
    'services' => [],
    'factories' => [],
    'abstract_factories' => [],
    'delegators' => [],
    'shared' => [],
    'shared_by_default' => [],
]);
