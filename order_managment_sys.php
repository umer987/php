<?php
// Simple PHP Order Management System

session_start();
// Initialize order system data
if (!isset($_SESSION['oms'])) {