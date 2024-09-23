<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home.index'); // Asegúrate de que 'app.blade.php' exista en resources/views
    }

    public function we()
    {
        return view('pages.home.we');
    }
}
