<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // form validation
        $request->validate(
            // validation rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16',
            ],
            // custom error messages
            [
                'text_username.required' => 'O username é obrigatório.',
                'text_username.email' => 'Por favor, insira um endereço de email válido.',
                'text_password.required' => 'A password é obrigatória.',
                'text_password.min' => 'Sua senha deve ter pelo menos :min caracteres.',
                'text_password.max' => 'Sua senha não pode ter mais de :max caracteres.',
            ]
        );

        // If validation passes, handle login logic here
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // get all the users from the database
        // $users = User::all()->toArray();

        // As an object instance of the model´s class
        $userModel = new User();
        $users = $userModel->all()->toArray();

        echo '<pre>';
        print_r($users);
    }

    public function logout()
    {
        echo 'Logout';
    }
}
