<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
Route::get('/', function () {
    $cars = ['civic', 'corolla','audi','surf'];
    return view('welcome',['cars'=>$cars]);
});

Route::get('/user', [User::class, 'getuser']); 
Route::get('/get-user/{name}', [User::class, 'getusername']); 


Route::get('/home', function(){
    return view('home');
});

Route::redirect('/welcome','/home');

Route::get('/login' , [User::class , 'login']);
Route::get('/getvie/{name}' , [User::class , 'getviewname']);

Route::get('/about/{name}', function($name){
   return view('about',['name'=> $name]) ;
});