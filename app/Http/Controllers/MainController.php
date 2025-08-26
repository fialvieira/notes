<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Note};
use App\Services\Operations;

class MainController extends Controller
{
    public function index()
    {
        // Load user´s notes
        $id = session('user.id');
        $notes = User::find($id)
            ->notes()
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

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

    public function editNoteSubmit(Request $request)
    {
        // Handle edit note submission
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

        // Check if note_id exists
        if ($request->note_id == null) {
            return redirect()->route('home')->with('error', 'Note ID is required.');
        }

        // Decrypt note_id
        $id = Operations::decryptId($request->note_id);

        // Find note
        $note = Note::find($id);
        if (!$note) {
            return redirect()->route('home')->with('error', 'Note not found.');
        }

        // Update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // Redirect to home
        return redirect()->route('home')->with('success', 'Note updated successfully.');
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        // Load note data
        $note = Note::find($id);
        if (!$note) {
            return redirect()->route('home')->with('error', 'Note not found.');
        }

        // Show delete confirmation view
        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptId($id);
        // Find note
        $note = Note::find($id);
        if (!$note) {
            return redirect()->route('home')->with('error', 'Note not found.');
        }

        // 1. Hard delete
        //$note->delete();

        // 2. Soft delete
        //$note->deleted_at = date('Y-m-d H:i:s');
        //$note->save();

        // 3. Soft delete property SoftDeletes in model
        $note->delete();

        // 4. Hard delete property SoftDeletes in model
        //$note->forceDelete();

        // Redirect to home
        return redirect()->route('home')->with('success', 'Note deleted successfully.');
    }
}
