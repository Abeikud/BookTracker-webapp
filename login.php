<header>
<nav>
    <div class="logo">
        <i class="fas fa-book-open"></i>
        <span>BookTrack</span>
    </div>
    
    <div class="nav-links" id="navLinks">
        <ul class="nav-list">
            <li><a href="index.html" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="view_books.php" class="nav-link"><i class="fas fa-book"></i> My Books</a></li>
            <li><a href="search.php" class="nav-link"><i class="fas fa-search"></i> Search</a></li>
            <li><a href="profile.php" class="nav-link"><i class="fas fa-user"></i> Profile</a></li>
            <li class="auth-buttons">
                <a href="logout.php" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>
    
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
</nav>
</header>

<script src="nav.js"></script>
<?php

session_start();
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $users = file('users.dat', FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($stored_user, $stored_pass) = explode('|', $user);
        if ($username === $stored_user && password_verify($password, $stored_pass)) {
            $_SESSION['user_id'] = $username;
            header("Location: view_books.php");
            exit();
        }
    }
    $error = "Invalid username or password";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Tracker - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>