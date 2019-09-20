<?php

namespace Core\Database;

use \PDO;
require_once '../config/config.php';

class PDOFactory
{
    static private $pdo = null;

    /**
     * @return PDO|null
     */
    public static function getConnection()
    {
        if (self::$pdo == null)
        {
            self::$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            self::$pdo->exec('SET NAMES UTF8');
        }
        return self::$pdo;
    }
}
