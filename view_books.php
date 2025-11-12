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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $year = trim($_POST['year']);
    $status = trim($_POST['status']);
    $rating = trim($_POST['rating']);
    $user = $_SESSION['user_id'];
    
    if (!empty($title) && !empty($author)) {
        $book_data = "$user|$title|$author|$year|$status|$rating\n";
        file_put_contents('books.dat', $book_data, FILE_APPEND);
        $success = "Book added successfully!";
    } else {
        $error = "Title and Author are required";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Tracker - Add Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Add New Book</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="title">Title:*</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:*</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="year">Publication Year:</label>
                <input type="number" id="year" name="year" min="1000" max="<?= date('Y') ?>">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="Want to Read">Want to Read</option>
                    <option value="Currently Reading">Currently Reading</option>
                    <option value="Finished Reading">Finished Reading</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Rating (1-5):</label>
                <select id="rating" name="rating">
                    <option value="0">Not rated</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <button type="submit" class="btn">Add Book</button>
        </form>
    </div>
</body>
</html>