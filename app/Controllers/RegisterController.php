<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        // Load the registration form view
        return view('register');
    }

    public function register()
    {
        // Handle the form submission for registration
    }
}
