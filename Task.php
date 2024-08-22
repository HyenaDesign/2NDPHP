<?php
include_once 'db.php';

class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getTasks($listId, $sortBy = 'deadline', $sortOrder = 'ASC') {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE list_id = :list_id ORDER BY $sortBy $sortOrder");
        $stmt->execute(['list_id' => $listId]);
        return $stmt->fetchAll();
    }

    public function addTask($listId, $title, $description, $deadline) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (list_id, title, description, deadline) VALUES (:list_id, :title, :description, :deadline)");
        $stmt->execute([
            'list_id' => $listId,
            'title' => $title,
            'description' => $description,
            'deadline' => $deadline
        ]);
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function markTaskAsDone($id) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET is_done = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
