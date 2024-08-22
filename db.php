<?php
class Database {
    private $pdo;

    public function __construct() {
        $host = '127.0.0.1'; 
        $dbname = 'todo_app'; 
        $username = 'root'; 
        $password = 'root'; 
        $port = '8889';     

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
?>
