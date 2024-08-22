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

    if ($stmt->rowCount() > 0) {
        throw new Exception('Username already exists.');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute([
        'username' => $username,
        'password' => $hashedPassword
    ]);

    header('Location: login.php');
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
