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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user_id'];
$books = file('books.dat', FILE_IGNORE_NEW_LINES);
$stats = [
    'total' => 0,
    'want_to_read' => 0,
    'currently_reading' => 0,
    'finished' => 0
];

foreach ($books as $book) {
    $data = explode('|', $book);
    if ($data[0] === $user) {
        $stats['total']++;
        switch ($data[4]) {
            case 'Want to Read': $stats['want_to_read']++; break;
            case 'Currently Reading': $stats['currently_reading']++; break;
            case 'Finished Reading': $stats['finished']++; break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = trim($_POST['current_password']);
    $new = trim($_POST['new_password']);
    $confirm = trim($_POST['confirm_password']);
    
    $users = file('users.dat', FILE_IGNORE_NEW_LINES);
    $updated_users = [];
    $password_changed = false;
    
    foreach ($users as $user_entry) {
        list($username, $password) = explode('|', $user_entry);
        if ($username === $user) {
            if (password_verify($current, $password)) {
                if ($new === $confirm) {
                    $hashed = password_hash($new, PASSWORD_DEFAULT);
                    $user_entry = "$username|$hashed";
                    $password_changed = true;
                    $success = "Password changed successfully!";
                } else {
                    $error = "New passwords do not match";
                }
            } else {
                $error = "Current password is incorrect";
            }
        }
        $updated_users[] = $user_entry;
    }
    
    if ($password_changed) {
        file_put_contents('users.dat', implode("\n", $updated_users));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Tracker - Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>My Profile</h1>
        <h2>Reading Statistics</h2>
        
        <div class="stats">
            <div class="stat-card">
                <h3>Total Books</h3>
                <p><?= $stats['total'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Want to Read</h3>
                <p><?= $stats['want_to_read'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Currently Reading</h3>
                <p><?= $stats['currently_reading'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Finished Reading</h3>
                <p><?= $stats['finished'] ?></p>
            </div>
        </div>
        
        <h2>Change Password</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="btn">Change Password</button>
        </form>
    </div>
</body>
</html>