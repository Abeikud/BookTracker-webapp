Book Tracker System - README

1. System Architecture:
- Uses PHP for server-side processing with file-based storage (.dat files)
- Implements user authentication with password hashing (login.php, register.php)
- Follows MVC pattern with separation of concerns

2. Key Features:
- User registration/login (lines 15-45 in register.php)
- Book management (add/view/search in respective files)
- Reading statistics (profile.php lines 20-35)
- Password change functionality (profile.php lines 40-70)

3. Data Storage:
- users.dat stores username|hashed_password (register.php line 35)
- books.dat stores user|title|author|year|status|rating (add_book.php line 18)

4. Security Measures:
- Input sanitization (view_books.php line 30-34)
- Password hashing with password_hash() (register.php line 35)
- Session protection (all files with session_start() and checks)

5. Error Handling:
- Form validation (register.php lines 15-25)
- User feedback (login.php lines 18-20, add_book.php lines 17-21)

6. Code Structure:
- header.php for consistent navigation
- CSS separated in styles.css
- Each feature in separate file for maintainability

Total lines: ~600 (including HTML)