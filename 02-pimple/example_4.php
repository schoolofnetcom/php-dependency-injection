<?php
require __DIR__.'/../vendor/autoload.php';

use Pimple\Container;

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

$ioc = new Container;

$ioc['ta'] = function ($c) {
    return new TestAdapter;
};

$ioc['tester'] = $ioc->factory(function ($c) {
    return new Tester($c['ta']);
});

$tester1 = $ioc['tester'];
$tester2 = $ioc['tester'];

var_dump($tester1, $tester2);
var_dump($tester1, $tester1);
