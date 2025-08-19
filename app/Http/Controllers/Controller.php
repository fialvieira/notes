<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function login()
    {
        echo 'Login';
    }

    public function logout()
    {
        echo 'Logout';
    }
}
