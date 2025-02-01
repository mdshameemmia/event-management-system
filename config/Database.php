<?php

class Database {
    private $host = "localhost";
    private $dbName = "event_management_system";
    private $userName = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        $this->connect(); 
    }

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
