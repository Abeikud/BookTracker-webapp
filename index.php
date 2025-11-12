<?php
session_start();
require_once 'header.php';

if (isset($_SESSION['user_id'])) {
    header("Location: view_books.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Tracker - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Welcome to Book Tracker</h1>
        <p>Track your personal book collection and reading progress.</p>
        
        <div class="auth-buttons">
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        </div>
    </div>
</body>
</html>