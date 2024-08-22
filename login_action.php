<?php
session_start();
include_once 'db.php';

try {
    $pdo = (new Database())->getPdo();

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        throw new Exception('Username and password are required.');
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        throw new Exception('Invalid username or password.');
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header('Location: index.php');
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
