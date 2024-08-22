<?php
include 'db.php';

try {
    $db = new Database();
    $pdo = $db->getPdo();
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
