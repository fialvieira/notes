<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Contracts\Encryption\DecryptException;
use App\Services\Operations;

class MainController extends Controller
{
    public function index()
    {
        // Load user´s notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        // Show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo "Creating a new note!";
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);
        echo "Editing note with ID: " . $id;
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        echo "Deleting note with ID: " . $id;
    }
}
