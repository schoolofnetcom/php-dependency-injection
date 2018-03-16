<?php

require __DIR__.'/../vendor/autoload.php';

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
    public function __construct(TestAdapter $adapter, string $message = 'Rodou um teste')
    {
        $adapter->runTest($message);
    }
}

(new SON\Di\Resolver)->resolveClass('Tester');

$func = function(Tester $tester, TestAdapter $test_adapter, $msg = 'Teste de closure') {
    var_dump($test_adapter->runTest($msg));
};


(new SON\Di\Resolver)->resolveFunction($func, ['msg'=>'Teste de closure com injeção externa']);
