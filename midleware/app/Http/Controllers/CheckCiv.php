<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckCiv extends Controller
{
    function check(){
        return view('midleware');
    }
    function checkhome(){
        return view('home');
    }
    function checkabout(){
        return view('about');
    }
}
