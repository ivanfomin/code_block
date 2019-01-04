<?php

namespace App;

class Db
{
    public $pdo;
    private static $connection;
    
    private function __construct()
    {
        $dsn = (include __DIR__ . '/../config.php')['database'];
        try {
            $this->pdo = new \PDO($dsn['connection'], $dsn['username'], $dsn['password'],
                [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        } catch (\PDOException $exception) {
            var_dump($exception);
            die;
        }
    }
    
    public static function getInstance()
    {
        if (static::$connection === null) {
            static::$connection = new static();
        }
        return static::$connection;
    }
    
}