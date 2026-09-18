<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
    function  getuser(){
        return 'SYED MUHAMMAD UMER';
    }
    function  getusername($name){
        return "name is ".$name;
    }
     function  getviewname($name){
        return view('getview' , ['name' => $name]);
    }
    function login(){
        return view('login');
    }
}
