<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contacts.index'); // Asegúrate de que 'app.blade.php' exista en resources/views
    }
}
