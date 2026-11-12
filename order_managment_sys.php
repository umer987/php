<?php
// Simple PHP Order Management System

session_start();
// Initialize order system data
if (!isset($_SESSION['oms'])) {
    $_SESSION['oms'] = [
        'products' => [
            1 => ['name' => 'Wireless Mouse', 'price' => 1500.00, 'stock' => 25],
            2 => ['name' => 'Mechanical Keyboard', 'price' => 4500.00, 'stock' => 10],
            3 => ['name' => 'USB-C Hub', 'price' => 2200.00, 'stock' => 15],
            4 => ['name' => 'Laptop Stand', 'price' => 1800.00, 'stock' => 8],
            5 => ['name' => 'Webcam HD', 'price' => 3200.00, 'stock' => 5]
        ],
        'customers' => [
            101 => ['name' => 'Ahmed Khan', 'email' => 'ahmed@mail.com', 'phone' => '0300-1111111', 'address' => 'Karachi'],
            102 => ['name' => 'Sara Ali', 'email' => 'sara@mail.com', 'phone' => '0300-2222222', 'address' => 'Lahore'],
              103 => ['name' => 'Bilal Ahmed', 'email' => 'bilal@mail.com', 'phone' => '0300-3333333', 'address' => 'Islamabad']
        ],
        'orders' => [], 
        'next_product' => 6,
        'next_customer' => 104,
        'next_order' => 1001
    ];
}
$oms = &$_SESSION['oms'];
$message = '';
$messageType = '';
function logMsg(&$msg, &$type, $text, $isError = false) {
    $msg = $text;
    $type = $isError ? 'error' : 'success';
}
function formatMoney($amount) {
    return 'Rs. ' . number_format($amount, 2);
}
function formatDate($d) {
    return date('d M Y, h:i A', strtotime($d));
}
function orderTotal($order) {
    $total = 0;
    foreach ($order['items'] as $item) {
        $total += $item['price'] * $item['qty'];
    }
    return $total;
}
$statusFlow = ['Pending', 'Processing', 'Shipped', 'Delivered'];

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add_product') {
    
    

      
        
