<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class loginController extends Controller
{
   
    public static function index(){
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('pos');
        }
 
        return back()->withErrors([
            'email' => 'Email atau Password Salah!!',
        ])->onlyInput('email');
  
    }

    public function logout(Request $request): RedirectResponse
{
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect()->route('login');
}

      





}
