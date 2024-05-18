<?php

namespace core;

use \src\Config;
use PDO;

class Database
{
    private static $_pdo;

    /**
     * Chama o banco cadastro em Config.php
     * se parametro $db for passado, e for uma numero idFilial, chama o banco da filial
     * @param string $db
     */
    public static function getInstance()
    {
        if (!isset(self::$_pdo)) {
            $String_conect = Config::DB_DRIVER . ":dbname=" . Config::DB_DATABASE . ";host=" . Config::DB_HOST;
            self::$_pdo = new \PDO($String_conect, Config::DB_USER, Config::DB_PASS);
            self::$_pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
            self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$_pdo;
    }

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    public function __wakeup()
    {
    }
}
