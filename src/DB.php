<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class DB
{
    private PDO $conn;

    public function __construct()
    {
        try {
            $dsn = "mysql:host=db;dbname=php-todos";
            $user = "change";
            $pass = "change";
            $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
            $this->conn = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            echo "DB connection error: {$e->getMessage()}";
            exit();
        }
    }

    public function conn(): PDO
    {
        return $this->conn;
    }
}
