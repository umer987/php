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

if ($action === 'add_member') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $email === '') {
        logMsg($message, $messageType, 'Name and email are required.', true);
    } else { $id = $lib['next_member']++;
        $lib['members'][$id] = ['name' => $name, 'email' => $email, 'phone' => $phone];
        logMsg($message, $messageType, "Member registered! Member ID: <strong>$id</strong>");
    }
}
if ($action === 'issue') {
    $bookId = intval($_POST['book_id'] ?? 0);
        $memberId = intval($_POST['member_id'] ?? 0);
    $days = intval($_POST['days'] ?? 14);

    if (!isset($lib['books'][$bookId])) {
        logMsg($message, $messageType, 'Book not found.', true);
    } elseif (!isset($lib['members'][$memberId])) {
         logMsg($message, $messageType, 'Member not found.', true);
    } elseif ($lib['books'][$bookId]['available'] < 1) {
         logMsg($message, $messageType, 'No copies available for this book.', true);
    } elseif ($days < 1 || $days > 90) {
        logMsg($message, $messageType, 'Loan period must be between 1 and 90 days.', true);
         } else {
        $due = date('Y-m-d', strtotime("+$days days"));
                $loanId = $lib['next_loan']++;
        $lib['loans'][$loanId] = [
            'book_id' => $bookId,
            'member_id' => $memberId,
            'borrow_date' => date('Y-m-d'),
            'due_date' => $due,
            'return_date' => null
        ];
        $lib['books'][$bookId]['available']--;
                logMsg($message, $messageType,
            "Book issued successfully! Loan ID: <strong>$loanId</strong>. Due: <strong>" . formatDate($due) . "</strong>");
         }}

if ($action === 'return') {
    $loanId = intval($_POST['loan_id'] ?? 0);
       if (!isset($lib['loans'][$loanId])) {
        logMsg($message, $messageType, 'Loan record not found.', true);
        } elseif ($lib['loans'][$loanId]['return_date'] !== null) {
        logMsg($message, $messageType, 'This book has already been returned.', true);
            } else {
        $loan = &$lib['loans'][$loanId];
        $loan['return_date'] = date('Y-m-d');
         $lib['books'][$loan['book_id']]['available']++;
        $late = daysLate($loan['due_date'], $loan['return_date']);
                $fine = $late * 10; // Rs. 10 per day
        $msg = "Book returned successfully!";
        if ($late > 0) {
                        $msg .= " <strong>Late by $late day(s). Fine: Rs. " . number_format($fine, 2) . "</strong>";
        }
logMsg($message, $messageType, $msg);
    }
}

if ($action === 'delete_book') {
     $bookId = intval($_POST['book_id'] ?? 0);
    $activeLoans = 0;
        foreach ($lib['loans'] as $l) {
