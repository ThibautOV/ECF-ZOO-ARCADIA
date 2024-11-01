<?php
// database.php

require_once 'config.php';

class Database {
    private $host = 'mysql-ovelacque.alwaysdata.net';
    private $db_name = 'ovelacque_arcadia';
    private $username = 'ovelacque_thibau';
    private $password = 'C6b9236a.';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>