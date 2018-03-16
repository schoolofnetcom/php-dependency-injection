<?php

//Depency injection

interface DatabaseDriver
{
    public function configure(array $config);
    public function connect();
}

class PdoDriver implements DatabaseDriver
{
    public function configure(array $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $pdo = new \PDO($this->config['dsn'], $this->config['user'], $this->config['passwd']);
    }
}

class MongoDbDriver implements DatabaseDriver
{
    public function configure(array $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $mongo = new \MongoClient($this->config['server']);
    }
}

class Database
{
    public function __construct(\DatabaseDriver $driver)
    {
        $this->driver = $driver;
    }
}

$ioc = [];
$ioc['db'] = function () {
    $pdo_driver = new PdoDriver();
    $pdo_driver->configure([]);

    return new Database($pdo_driver);
};

$ioc['db_mongo'] = function () {
    $mongo_driver = new MongoDbDriver();
    $mongo_driver->configure([]);

    return new Database($mongo_driver);
};

$ioc['db']();
