<?php
// Simple PHP Library Management System
// Run in a PHP-enabled server (XAMPP, MAMP, or: php -S localhost:8000)

session_start();

// Initialize library data
if (!isset($_SESSION['library'])) {
    $_SESSION['library'] = [
        'books' => [   1 => ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'isbn' => '9780743273565', 'copies' => 3, 'available' => 3],
            2 => ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'isbn' => '9780061120084', 'copies' => 2, 'available' => 2],
            3 => ['title' => '1984', 'author' => 'George Orwell', 'isbn' => '9780451524935', 'copies' => 4, 'available' => 4],
            4 => ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '9780141439518', 'copies' => 1, 'available' => 1]
        ],