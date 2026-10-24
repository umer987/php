<?php
// Simple PHP Library Management System
// Run in a PHP-enabled server (XAMPP, MAMP, or: php -S localhost:8000)

session_start();

// Initialize library data
if (!isset($_SESSION['library'])) {
    $_SESSION['library'] = [
        'books' => [