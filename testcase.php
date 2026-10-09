<?php
// ============================================================
// RAW PHP CRUD API — Tasks
// Run:  php -S localhost:8000
// Test: http://localhost:8000/api.php/tasks
// ============================================================

// ---------- 1. CONFIG & HEADERS ----------
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

const DB_HOST = 'localhost';
const DB_NAME = 'task_db';
const DB_USER = 'root';
const DB_PASS = '';

// ---------- 2. DATABASE CONNECTION (PDO) ----------
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            respond(['error' => 'DB connection failed: ' . $e->getMessage()], 500);
        }
    }
    return $pdo;
}

// ---------- 3. HELPERS ----------
function respond($data, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function input(): array
{
    $raw = file_get_contents('php://input');
    return json_decode($raw, true) ?? [];
}

function validate(array $data, array $rules): array
{
    $errors = [];
    foreach ($rules as $field => $rule) {
        $value = $data[$field] ?? null;
        foreach (explode('|', $rule) as $r) {
            if ($r === 'required' && ($value === null || $value === '')) {
                $errors[$field] = "$field is required";
            } elseif ($r === 'string' && $value !== null && !is_string($value)) {
                $errors[$field] = "$field must be a string";
            } elseif (str_starts_with($r, 'max:') && $value !== null) {
                $max = (int) substr($r, 4);
                if (strlen($value) > $max) $errors[$field] = "$field max $max chars";
            } elseif ($r === 'bool' && $value !== null && !is_bool($value) && !in_array($value, [0, 1, '0', '1'], true)) {
                $errors[$field] = "$field must be boolean";
            }
        }
    }
    if ($errors) respond(['errors' => $errors], 422);
    return $data;
}

// ---------- 4. MIDDLEWARE ----------
<?php

$greeting = "Hello, World!";
$number = 42;
$pi = 3.14159;
$isActive = true;
$fruits = ["apple", "banana", "cherry"];
$person = [
    "name" => "Alice",
    "age" => 30,
    "city" => "Wonderland"
];

define("SITE_NAME", "RawPHP");
const VERSION = "1.0";

echo "<h1>$greeting</h1>";
echo "<p>Welcome to " . SITE_NAME . " version " . VERSION . "</p>";

if ($isActive) {
    echo "<p>The system is active.</p>";
} else {
    echo "<p>The system is inactive.</p>";
}

echo "<h2>Fruits:</h2><ul>";
foreach ($fruits as $fruit) {
    echo "<li>$fruit</li>";
}
echo "</ul>";

function add($a, $b) {
    return $a + $b;
}

function greet($name = "Guest") {
    return "Hello, $name!";
}

echo "<p>2 + 3 = " . add(2, 3) . "</p>";
echo "<p>" . greet("Bob") . "</p>";
echo "<p>" . greet() . "</p>";


      


























