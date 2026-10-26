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
         'members' => [
            101 => ['name' => 'Alice Brown', 'email' => 'alice@mail.com', 'phone' => '0300-1111111'],
            102 => ['name' => 'Bob Wilson', 'email' => 'bob@mail.com', 'phone' => '0300-2222222'],
            103 => ['name' => 'Charlie Davis', 'email' => 'charlie@mail.com', 'phone' => '0300-3333333']
        ],
        'loans' => [], // each: book_id, member_id, borrow_date, due_date, return_date (null if active)
        'next_book' => 5,
        'next_member' => 104,
        'next_loan' => 1
    ];
}
$lib = &$_SESSION['library'];
$message = '';
$messageType = '';
// ---------- Helpers ----------
function logMsg(&$msg, &$type, $text, $isError = false) {
    $msg = $text;
    $type = $isError ? 'error' : 'success';
}
function formatDate($d) {
    return date('d M Y', strtotime($d));
}

function daysLate($dueDate, $returnDate = null) {
    $end = $returnDate ? strtotime($returnDate) : time();
    $due = strtotime($dueDate);
    $diff = floor(($end - $due) / 86400);
    return $diff > 0 ? $diff : 0;
}
// ---------- Actions ----------
$action = $_POST['action'] ?? $_GET['action'] ?? '';
// ADD BOOK FOR PROGRAM
if ($action === 'add_book') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $isbn = trim($_POST['isbn'] ?? '');
    $copies = intval($_POST['copies'] ?? 1);

    if ($title === '' || $author === '' || $copies < 1) {
        logMsg($message, $messageType, 'Title, author and copies (>=1) are required.', true);
    } else {
        $id = $lib['next_book']++;
        $lib['books'][$id] = [
            'title' => $title, 'author' => $author, 'isbn' => $isbn,
            'copies' => $copies, 'available' => $copies
        ];
        logMsg($message, $messageType, "Book added successfully! Book ID: <strong>$id</strong>");
    }
}

// ADD MEMBER
if ($action === 'add_member') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $email === '') {
        logMsg($message, $messageType, 'Name and email are required.', true);
    } else {