<?php
$name = 'umer';
$age = 22;

echo'my name and age is ',$name ," ", $age;

Route::get('/about', function () {
    return 'About Page';
});



Route::get('/contact', function () {
    return 'Contact Page';
});

?>


