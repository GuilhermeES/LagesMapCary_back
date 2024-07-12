<?php

namespace MapcityBack\Database;

use PDO;
use PDOException;

class Database
{
    private static $host = 'localhost';
    private static $dbName = 'mapcarylages';
    private static $username = 'root';
    private static $password = '';
    private static $pdo = null;

    public static function connection () {
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$username, self::$password);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
