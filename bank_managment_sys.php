<?php
// Simple PHP Bank Management System
// Run this file in a PHP-enabled server environment (e.g., XAMPP, MAMP, or PHP built-in server)

session_start();
// Initialize bank data if not exists
if (!isset($_SESSION['bank'])) {
    $_SESSION['bank'] = [
        'accounts' => [
            1001 => ['name' => 'John Doe', 'balance' => 5000.00, 'pin' => '1234'],
            1002 => ['name' => 'Jane Smith', 'balance' => 3500.50, 'pin' => '5678'],
            1003 => ['name' => 'Bob Johnson', 'balance' => 12000.75, 'pin' => '9012']
        ],
        'next_account' => 1004,
        'transactions' => []
    ];
}


$bank = &$_SESSION['bank'];
$message = '';
$messageType = '';

// Helper: Log transaction
function logTransaction(&$bank, $accountNo, $type, $amount, $balance) {
    $bank['transactions'][] = [
        'time' => date('Y-m-d H:i:s'),
        'account' => $accountNo,
        'type' => $type,
        'amount' => $amount,
        'balance' => $balance
    ];
}

// Helper: Format currency
function formatMoney($amount) {
    return '$' . number_format($amount, 2);
}


// Handle actions
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// CREATE ACCOUNT
if ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $initialDeposit = floatval($_POST['initial_deposit'] ?? 0);
    $pin = trim($_POST['pin'] ?? '');

    if ($name === '' || strlen($pin) !== 4 || !ctype_digit($pin)) {
        $message = 'Please enter a valid name and a 4-digit PIN.';
        $messageType = 'error';
    } elseif ($initialDeposit < 0) {
        $message = 'Initial deposit cannot be negative.';
        $messageType = 'error';
    } else {
        $accountNo = $bank['next_account']++;
        $bank['accounts'][$accountNo] = [
            'name' => $name,
            'balance' => $initialDeposit,
            'pin' => $pin
        ];
        logTransaction($bank, $accountNo, 'Account Created', $initialDeposit, $initialDeposit);
        $message = "Account created successfully! Account Number: <strong>$accountNo</strong>";
        $messageType = 'success';
    }
}