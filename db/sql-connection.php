<?php

class SqlConnection
{
    private static $instance;

    private function __construct()
    {
        $hostname = "localhost";
        $database = "petshop";
        $username = "root";
        $password = "nZHeEYlOS5bs";

        $dsn = "mysql:host=$hostname;dbname=$database";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            self::$instance = new PDO($dsn, $username, $password, $options);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getConnection()
    {
        if (!isset(self::$instance)) {
            new SqlConnection();
        }
        return self::$instance;
    }
}