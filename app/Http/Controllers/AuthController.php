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

        // Check if the user exists and is not deleted
        $user = User::where('username', $username)
            ->where('deleted_at', null)
            ->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['loginError' => 'Usuário não encontrado ou deletado.']);
        }

        // Check if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['loginError' => 'Senha incorreta.']);
        }

        // Update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // Login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // Redirect to home
        return redirect()->to('/');
    }

    public function logout()
    {
        // Logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
