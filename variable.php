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
Route::get('/greet/{name?}', function ($name = 'Guest') {
    return "Hello, $name!";
});

// POST - Create resource
Route::post('/posts', function () {
    return 'Post created';
});

// PUT - Full update
Route::put('/posts/{id}', function ($id) {
    return "Post $id fully updated";
});

// PATCH - Partial update
Route::patch('/posts/{id}', function ($id) {
    return "Post $id partially updated";
});

// DELETE - Remove resource
Route::delete('/posts/{id}', function ($id) {
    return "Post $id deleted";
});

// Multiple methods on same URI
Route::match(['get', 'post'], '/contact', function () {
    return 'Contact page (GET or POST)';
});

// Any HTTP method
Route::any('/webhook', function () {
    return 'Webhook received';
});

// Redirect route
Route::redirect('/old-page', '/about');

// View route (no closure needed)
Route::view('/terms', 'terms');

// Route with constraints (only numeric IDs)
Route::get('/user/{id}', function ($id) {
    return "User ID: $id";
})->where('id', '[0-9]+');

// Route group with prefix + name prefix
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Admin Dashboard';
    })->name('dashboard');

    Route::get('/settings', function () {
        return 'Admin Settings';
    })->name('settings');
});

// Resource routes (7 routes in 1 line)
Route::resource('posts', PostController::class);

// Fallback route (must be last)
Route::fallback(function () {
    return response('Page Not Found', 404);
});








?>


