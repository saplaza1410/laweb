<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.services.index'); // Asegúrate de que 'app.blade.php' exista en resources/views
    }
}
