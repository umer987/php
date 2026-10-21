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


// DEPOSIT
if ($action === 'deposit') {
    $accountNo = intval($_POST['account_no'] ?? 0);
    $amount = floatval($_POST['amount'] ?? 0);

    if (!isset($bank['accounts'][$accountNo])) {
        $message = 'Account not found.';
        $messageType = 'error';
    } elseif ($amount <= 0) {
        $message = 'Deposit amount must be greater than zero.';
        $messageType = 'error';
    } else {
        $bank['accounts'][$accountNo]['balance'] += $amount;
        logTransaction($bank, $accountNo, 'Deposit', $amount, $bank['accounts'][$accountNo]['balance']);
        $message = 'Deposit successful! New balance: ' . formatMoney($bank['accounts'][$accountNo]['balance']);
        $messageType = 'success';
    }
}


// WITHDRAW
if ($action === 'withdraw') {
    $accountNo = intval($_POST['account_no'] ?? 0);
    $amount = floatval($_POST['amount'] ?? 0);
    $pin = trim($_POST['pin'] ?? '');

    if (!isset($bank['accounts'][$accountNo])) {
        $message = 'Account not found.';
        $messageType = 'error';
            } elseif ($bank['accounts'][$accountNo]['pin'] !== $pin) {
        $message = 'Invalid PIN.';
        $messageType = 'error';
    } elseif ($amount <= 0) {
             $message = 'Withdrawal amount must be greater than zero.';
        $messageType = 'error';
    } elseif ($amount > $bank['accounts'][$accountNo]['balance']) {
          $message = 'Insufficient funds. Available: ' . formatMoney($bank['accounts'][$accountNo]['balance']);
        $messageType = 'error';
    } else {
                $bank['accounts'][$accountNo]['balance'] -= $amount;
        logTransaction($bank, $accountNo, 'Withdrawal', $amount, $bank['accounts'][$accountNo]['balance']);
        $message = 'Withdrawal successful! New balance: ' . formatMoney($bank['accounts'][$accountNo]['balance']);
        $messageType = 'success';
    }
}
// TRANSFER
if ($action === 'transfer') {
    $from = intval($_POST['from_account'] ?? 0);
    $to = intval($_POST['to_account'] ?? 0);
    $amount = floatval($_POST['amount'] ?? 0);
    $pin = trim($_POST['pin'] ?? '');