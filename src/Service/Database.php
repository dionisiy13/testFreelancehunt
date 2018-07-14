<?php

namespace Core\Service;

class Database
{
    private static $connection = null;

    private function __construct()
    {}

    public static function getDB(): \PDO
    {
        if (null == self::$connection) {
            $config = getConfig();
            $config = $config['database'];
            // Create the connection
            $dsn = ''.
                'mysql'.
                ':host='.$config['host'].
                ';dbname='.$config['dbname'];
            try {
                self::$connection = new \PDO($dsn, $config['username'], $config['password']);
            } catch (PDOException $e) {
                echo __LINE__.$e->getMessage();
                return false;
            }
        }

        return self::$connection;
    }
}
