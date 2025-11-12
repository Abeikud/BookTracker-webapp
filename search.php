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
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = strtolower(trim($_GET['query']));
    
    foreach ($books as $book) {
        $data = explode('|', $book);
        if ($data[0] === $user && 
            (strpos(strtolower($data[1]), $query) !== false || 
             strpos(strtolower($data[2]), $query) !== false)) {
            $results[] = $data;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Tracker - Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Search Books</h1>
        
        <form method="get" class="search-form">
            <input type="text" name="query" placeholder="Search by title or author" 
                   value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>">
            <button type="submit" class="btn">Search</button>
        </form>
        
        <?php if (!empty($results)): ?>
            <h2>Search Results</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book[1]) ?></td>
                            <td><?= htmlspecialchars($book[2]) ?></td>
                            <td><?= htmlspecialchars($book[3]) ?></td>
                            <td><?= htmlspecialchars($book[4]) ?></td>
                            <td>
                                <?php if ($book[5] > 0): ?>
                                    <?= str_repeat('★', $book[5]) . str_repeat('☆', 5 - $book[5]) ?>
                                <?php else: ?>
                                    Not rated
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_GET['query'])): ?>
            <p>No books found matching your search.</p>
        <?php endif; ?>
    </div>
</body>
</html>