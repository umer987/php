<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/contact-us',function(){
    return view('contactus');
});


Route::get('/about',function(){
    return view('aboutpage');
});

Route::view('home/login/page/signin', 'aboutpage' )->name('abc');
Route::view('home' , 'home')->name('hm');
Route::get('/show', [HomeController::class , 'show']);



Route::prefix('student')->group(function(){
Route::get('/show',[HomeController::class , 'signup']);
Route::get('/dashboard',[HomeController::class , 'dashboard']);
Route::get('/schedule',[HomeController::class , 'schedule']);



});
//group of middleware on 1 route
Route::get('/gm',[HomeController::class , 'gm'])->middleware('group1');


//one middleware on group of routes
Route::middleware('group1')->group(function(){

Route::get('/show',[HomeController::class , 'signup']);
Route::get('/dashboard',[HomeController::class , 'dashboard']);
Route::get('/schedule',[HomeController::class , 'schedule']);
});
