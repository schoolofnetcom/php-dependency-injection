<?php

require __DIR__.'/../vendor/autoload.php';

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class TestAdapter
{
    public function __construct()
    {
        var_dump(TestAdapter::class.'::__construct()');
    }

    public function runTest($message)
    {
        var_dump($message);
    }
}

class Tester
{
    public function __construct(TestAdapter $adapter)
    {
        $adapter->runTest('Rodou um teste');
    }
}

class TesterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Tester($container->get('ta'));
    }
}

$serviceManager = new ServiceManager([
    'factories' => [
        'ta' => function (ContainerInterface $c) {
            return new TestAdapter;
        },
        'tester' => TesterFactory::class,
    ],
  /*  'shared' => [
        'tester' => false
    ]*/
    'shared_by_default' => false
]);

$tester1 = $serviceManager->get('tester');
$tester2 = $serviceManager->get('tester');

var_dump($tester1 === $tester2);
var_dump($tester1, $tester2);
