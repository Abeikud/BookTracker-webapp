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

<?php

session_start();
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    } else {
        // Check if user exists
        $users = file('users.dat', FILE_IGNORE_NEW_LINES);
        foreach ($users as $user) {
            list($existing_user) = explode('|', $user);
            if ($username === $existing_user) {
                $error = "Username already taken";
                break;
            }
        }
        
        if (!isset($error)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents('users.dat', "$username|$hashed\n", FILE_APPEND);
            $_SESSION['user_id'] = $username;
            header("Location: view_books.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Tracker - Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Register</h1>
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
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>