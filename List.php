<?php
include_once 'db.php';

class ListModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllLists() {
        $stmt = $this->pdo->query("SELECT * FROM lists");
        return $stmt->fetchAll();
    }

    public function addList($name) {
        $stmt = $this->pdo->prepare("INSERT INTO lists (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
    }

    public function deleteList($id) {
        $stmt = $this->pdo->prepare("DELETE FROM lists WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
