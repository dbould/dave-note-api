<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function getAllNotes(Request $request)
    {
        $notes = Note::All();

        return $notes;
    }

    public function getNote(Request $request, $id)
    {
        $note = new Note();
        $note = $note->findOrFail($id);

        return $note;
    }

    public function createNote(Request $request)
    {
        $content = json_decode($request->getContent());

        $createValues = [
            'title' => $content->title,
            'note' => $content->note,
            'user_id' => 0,
        ];

        $note = new Note();
        $note = $note->create($createValues);

        return $note;
    }

    public function updateNote(Request $request, $id)
    {
        $note = new Note();
        $note = $note->findOrFail($id);

        return $note;
    }
}