<?php
declare(strict_types=1);

class Database
{
    private static ?mysqli $instance = null;

    private function __construct() {}

    public static function getInstance(): mysqli
    {
        if (self::$instance === null) {
            self::$instance = new mysqli("localhost", "root", "", "auth_db");
            if (self::$instance->connect_error) {
                die("Connection failed: " . self::$instance->connect_error);
            }
        }
        return self::$instance;
    }
}

?>