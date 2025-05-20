<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function pelaporan()
    {
        return view('frontend.pelaporan');
    }

    public function modul()
    {
        return view('frontend.modul');
    }
}
