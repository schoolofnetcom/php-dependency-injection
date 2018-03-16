<?php

//Depency inversion

class Database
{
    public function __construct(\PDO $pdo)
    {
        $this->driver = $pdo;
    }
}

$ioc = [];
$ioc['db'] = function () {
    $pdo = new \PDO('dsn', 'user', '123');
    return new Database($pdo);
};

$ioc['db']();
