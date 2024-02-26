<?php

namespace App;

class DatabaseConnection
{
    private $conn;
    public function __construct()
    {
        $this->conn = new \PDO('mysql:host=localhost;dbname=softy', 'root', '');

        $tables = 
        "
        CREATE TABLE IF NOT EXISTS Users (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NULL,
            password VARCHAR(255) NOT NULL,
            registrationDate DATE NOT NULL,
            isAdmin BOOL NOT NULL DEFAULT 0
        );
        ";
        
        $this->conn->exec($tables);
    }

    public function getConnection()
    {
        return $this->conn;
    }
}