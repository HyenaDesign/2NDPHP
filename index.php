<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'db.php';
include_once 'Task.php';
include_once 'List.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$pdo = $db->getPdo();

$taskModel = new Task($pdo);
$listModel = new ListModel($pdo);

$lists = $listModel->getAllLists();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Todo App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addTaskForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.post('ajax.php', formData + '&action=addTask', function(response) {
                    if (response.status === 'success') {
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                }, 'json');
            });

            $('.commentForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.post('ajax.php', formData + '&action=addComment', function(response) {
                    if (response.status === 'success') {
                        location.reload(); 
                    } else {
                        alert('Error: ' + response.message);
                    }
                }, 'json');
            });
        });

        function addTask(listId, title, description, deadline) {
            $.post('ajax.php', {
                action: 'addTask',
                list_id: listId,
                title: title,
                description: description,
                deadline: deadline
            }, function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            }, 'json');
        }

        function deleteTask(taskId) {
            $.post('ajax.php', {
                action: 'deleteTask',
                task_id: taskId
            }, function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            }, 'json');
        }

        function markTaskAsDone(taskId) {
            $.post('ajax.php', {
                action: 'markTaskAsDone',
                task_id: taskId
            }, function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            }, 'json');
        }

        function addComment(taskId, comment) {
            $.post('ajax.php', {
                action: 'addComment',
                task_id: taskId,
                comment: comment
            }, function(response) {
                if (response.status === 'success') {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            }, 'json');
        }
    </script>
</head>
<body>
    <h1>Todo Application</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>

    <form id="addTaskForm">
        <input type="hidden" name="list_id" value="1" />
        <input type="text" name="title" placeholder="Title" required />
        <textarea name="description" placeholder="Description"></textarea>
        <input type="date" name="deadline" />
        <button type="submit">Add Task</button>
    </form>

    <div id="taskList">
        <?php
        foreach ($lists as $list) {
            echo "<h2>List: " . htmlspecialchars($list['name']) . "</h2>";
            $tasks = $taskModel->getTasks($list['id'], 'deadline', 'ASC');
            foreach ($tasks as $task) {
                echo "<div>";
                echo "<h3>" . htmlspecialchars($task['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($task['description']) . "</p>";
                echo "<p>Deadline: " . htmlspecialchars($task['deadline']) . "</p>";
                echo "<button onclick='markTaskAsDone(" . $task['id'] . ")'>Mark as Done</button>";
                echo "<button onclick='deleteTask(" . $task['id'] . ")'>Delete Task</button>";
                echo "<form class='commentForm'>";
                echo "<input type='hidden' name='task_id' value='" . $task['id'] . "' />";
                echo "<textarea name='comment' placeholder='Add a comment'></textarea>";
                echo "<button type='submit'>Add Comment</button>";
                echo "</form>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>
