<?php
include_once 'db.php';
include_once 'Task.php';
include_once 'Comment.php';

$db = new Database();
$pdo = $db->getPdo();

$taskModel = new Task($pdo);
$commentModel = new Comment($pdo);

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'addTask':
        $listId = $_POST['list_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        
        try {
            $taskModel->addTask($listId, $title, $description, $deadline);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'deleteTask':
        $taskId = $_POST['task_id'];
        
        try {
            $taskModel->deleteTask($taskId);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'markTaskAsDone':
        $taskId = $_POST['task_id'];
        
        try {
            $taskModel->markTaskAsDone($taskId);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case 'addComment':
        $taskId = $_POST['task_id'];
        $comment = $_POST['comment'];
        
        try {
            $commentModel->addComment($taskId, $comment);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>
