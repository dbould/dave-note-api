<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function getAllNotes(Request $request)
    {
        $notes = Note::where('is_deleted', '=', '0')->orderBy('updated_at', 'desc')->get();

        return $notes;
    }

    public function getLatestUpdatedNote()
    {
        $note = Note::where('is_deleted', '=', '0')->orderBy('updated_at', 'desc')->firstOrFail();

        return $note;
    }

    public function getNote(Request $request, $id)
    {
        $note = Note::where('id', '=', $id)->where('is_deleted', '=', '0')->firstOrFail();

        return $note;
    }

    public function createNote(Request $request)
    {
        $content = json_decode($request->getContent());

        $createValues = [
            'title' => $content->title,
            'note' => $content->note,
            'user_id' => 0,
            'is_deleted' => 0,
        ];


        $note = Note::create($createValues);

        return $note->id;
    }

    public function updateNote(Request $request, $id)
    {
        $content = json_decode($request->getContent());

        $updateValues = [
            'title' => $content->title,
            'note' => $content->note,
            'user_id' => 0,
        ];

        $note = Note::find($id);
        $note->update($updateValues);
    }

    public function deleteNote(Request $request, $id)
    {
        $note = Note::find($id);
        $note->is_deleted = 1;
        $note->save();
    }
}