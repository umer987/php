<?php
// raw_language.php
// A raw PHP program demonstrating basic language features.

// 1. Variables and data types
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

// 2. Constants
define("SITE_NAME", "RawPHP");
const VERSION = "1.0";

// 3. String interpolation
echo "<h1>$greeting</h1>";
echo "<p>Welcome to " . SITE_NAME . " version " . VERSION . "</p>";

// 4. Conditionals
if ($isActive) {
    echo "<p>The system is active.</p>";
} else {
    echo "<p>The system is inactive.</p>";
}

// 5. Loops
echo "<h2>Fruits:</h2><ul>";
foreach ($fruits as $fruit) {
    echo "<li>$fruit</li>";
}
echo "</ul>";

// 6. Functions
