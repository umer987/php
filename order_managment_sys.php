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