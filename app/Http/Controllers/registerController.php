<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class registerController extends Controller
{
    public static function index(){
        return view('login.register');
    }

    // public static function store(Request $request){
    //     return $request->all();
    // }

    public static function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:100',
        ]);

   }
}
