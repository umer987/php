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



Route::get('/user/{id}', function ($id) {
    return 'User ID: ' . $id;
});

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/user/{id}', [PageController::class, 'user'])->name('user');

Route::post('/posts', function () {
    return 'Create a new post';
});

Route::put('/posts/{id}', function ($id) {
    return "Replace post $id";
});
?>


