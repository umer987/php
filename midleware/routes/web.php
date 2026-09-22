<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckCiv;
use App\Http\Middleware\civil;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/checkciv', [CheckCiv::class,'check' ]);
Route::get('/home', [CheckCiv::class,'checkhome' ])->middleware(civil::class);
Route::get('/about', [CheckCiv::class,'checkabout' ]);
