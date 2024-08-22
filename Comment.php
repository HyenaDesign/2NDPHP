<?php
include_once 'db.php';

class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addComment($taskId, $comment) {
        $stmt = $this->pdo->prepare("INSERT INTO comments (task_id, comment) VALUES (:task_id, :comment)");
        $stmt->execute([
            'task_id' => $taskId,
            'comment' => $comment
        ]);
    }

    public function getComments($taskId) {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE task_id = :task_id");
        $stmt->execute(['task_id' => $taskId]);
        return $stmt->fetchAll();
    }
}
?>
