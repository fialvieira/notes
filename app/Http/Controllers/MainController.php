<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Note;
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
        // Show new note view
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        // Handle new note submission
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:5|max:3000'
            ],
            [
                'text_title.required' => 'O título é obrigatório.',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres.',
                'text_title.max' => 'O título não pode ter mais de :max caracteres.',
                'text_note.required' => 'O texto da nota é obrigatório.',
                'text_note.min' => 'O texto da nota deve ter pelo menos :min caracteres.',
                'text_note.max' => 'O texto da nota não pode ter mais de :max caracteres.'
            ]
        );

        // Get user id
        $id = session('user.id');

        // Create new note
        $note = new Note();
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->user_id = $id;
        $note->save();

        // Redirect to home
        return redirect()->route('home')->with('success', 'Note created successfully.');
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);
        // Load note data
        $note = Note::find($id);
        if (!$note) {
            return redirect()->route('home')->with('error', 'Note not found.');
        }

        // Show edit note view
        return view('edit_note', ['note' => $note]);
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        echo "Deleting note with ID: " . $id;
    }
}
