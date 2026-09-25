<?php
$name = 'umer';
$age = 22;

echo'my name and age is ',$name ," ", $age;








<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// GET - Home page (named route)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// GET - Simple string response
Route::get('/about', function () {
    return 'About Page';
});

// GET - With optional parameter
























?>


