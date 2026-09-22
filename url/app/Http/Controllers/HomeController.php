<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function show(){
        return to_route('hm');
    }
     function signup(){
        return view('studentshow');
    }
     function dashboard(){
        return view('studentdashboard');
    }
     function schedule(){
        return view('schedule');
    }
     function gm(){
        return view('checkgroup');
    }
}
