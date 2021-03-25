<?php

namespace App\Core;

use PDO;
use App\Core\Contracts\DatabaseConnectionInterface;

class MySQLConnection implements DatabaseConnectionInterface
{
    protected static $config = [];

    /**
     * MySQLConnection constructor.
     */
    public function __construct()
    {
        self::getConfig();
    }

    /**
     * Establish the db connection
     *
     * @return PDO
     */
    public function connect()
    {
        try {
            return new PDO("mysql:host=" . self::getConfigValue('host') . ";dbname=" . self::getConfigValue('database'),
                self::getConfigValue('username'),
                self::getConfigValue('password'),
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                ]
            );

        } catch (\PDOException $e) {
            error_log($e->getMessage());
            exit('Could not established the database connection. Please check your configuration.');
        }
    }

    /**
     * DB configurations
     *
     * @return mixed
     */
    protected static function getConfig()
    {
        self::$config = include('./config/database.php');

        if (!isset(self::$config['host']) ||
            !isset(self::$config['port']) ||
            !isset(self::$config['database']) ||
            !isset(self::$config['username']) ||
            !isset(self::$config['password'])
        ) {
            throw new \InvalidArgumentException("Database configurations are missing");
        }
    }

    /**
     * @param string $key
     * @return string
     */
    protected static function getConfigValue(string $key)
    {
        return self::$config[$key] ?? null;
    }
}
