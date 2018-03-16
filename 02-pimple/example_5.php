<?php
require __DIR__.'/../vendor/autoload.php';

use Pimple\Container;

$ioc = new Container;

$ioc['multiplicador'] = 10;

$ioc['sum'] = $ioc->protect(function ($a, $b) {
    return $a+$b;
});

$sum = $ioc['sum'];

echo $sum(1, 2) * $ioc['multiplicador'];
