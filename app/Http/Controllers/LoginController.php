<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
         return view('admin.auth.login');
    }

    public function loginProses(Request $request)
    {
         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('homeadmin');
        }else{
              return back()->withErrors(['errors' => 'Email atau password salah.'])->withInput();
        }
    }

    public function register()
    {
        return view('admin.auth.register');
    }
}
