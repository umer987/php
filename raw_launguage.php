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
function add($a, $b) {
    return $a + $b;
}

function greet($name = "Guest") {
    return "Hello, $name!";
}

echo "<p>2 + 3 = " . add(2, 3) . "</p>";
echo "<p>" . greet("Bob") . "</p>";
echo "<p>" . greet() . "</p>";

// 7. Arrays and array functions
$numbers = [5, 3, 8, 1, 9];
sort($numbers);
echo "<p>Sorted numbers: " . implode(", ", $numbers) . "</p>";

$sum = array_sum($numbers);
echo "<p>Sum of numbers: $sum</p>";

// 8. Associative array iteration
echo "<h2>Person Details:</h2><ul>";
foreach ($person as $key => $value) {
    echo "<li><strong>$key:</strong> $value</li>";
}
echo "</ul>";

// 9. Switch statement
$day = "Monday";
switch ($day) {
    case "Monday":
        echo "<p>Start of the work week.</p>";
        break;
    case "Friday":
        echo "<p>Almost weekend!</p>";
        break;
    default:
        echo "<p>Just another day.</p>";
}
?>