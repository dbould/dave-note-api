<?php

namespace Tests\Feature;

use App\Note;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NoteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetAllNotes()
    {
        $data1 = '{"title":"This is my first note","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data1);
        $id1 = $createResponse->getContent();

        $data2 = '{"title":"This is my second note","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data2);
        $id2 = $createResponse->getContent();

        $dataDecoded1 = json_decode($data1);
        $dataDecoded2 = json_decode($data2);

        $getResponse = $this->get('api/notes');
        $actual = json_decode($getResponse->getContent(), true);

        unset($actual[0]['created_at']);
        unset($actual[0]['updated_at']);

        unset($actual[1]['created_at']);
        unset($actual[1]['updated_at']);

        $expected = [
            0 => ['id' => $id1,
                  'title' => $dataDecoded1->title,
                  'note' => $dataDecoded1->note,
                  'user_id' => 0,
                 ],
            1 => ['id' => $id2,
                  'title' => $dataDecoded2->title,
                  'note' => $dataDecoded2->note,
                  'user_id' => 0,
                ],
        ];

        $this->assertEquals($expected, $actual);

        $note = Note::find($id1);
        $note->delete();

        $note = Note::find($id2);
        $note->delete();
    }

    public function testCantFindDeletedNotes()
    {
        $data1 = '{"title":"This is my first note","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data1);
        $id1 = $createResponse->getContent();

        $data2 = '{"title":"This is my second note","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data2);
        $id2 = $createResponse->getContent();

        $this->call('post', 'api/note/delete/' . $id1);
        $this->call('post', 'api/note/delete/' . $id2);

        $getResponse = $this->get('api/notes');
        $actual = json_decode($getResponse->getContent(), true);

        $expected = [];

        $this->assertEquals($expected, $actual);

        $note = Note::find($id1);
        $note->delete();

        $note = Note::find($id2);
        $note->delete();
    }

    public function testGetNote()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data);
        $id = $createResponse->getContent();

        $dataDecoded = json_decode($data);

        $expected = [
            'id' => $id,
            'title' => $dataDecoded->title,
            'note' => $dataDecoded->note,
            'user_id' => 0,
        ];

        $getResponse = $this->get('api/note/' . $id);
        $actual = json_decode($getResponse->getContent(), true);

        unset($actual['created_at']);
        unset($actual['updated_at']);

        $this->assertEquals($expected, $actual);

        $note = Note::find($id);
        $note->delete();
    }

    public function testCantFindDeletedNote()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data);
        $id = $createResponse->getContent();

        $this->call('post', 'api/note/delete/' . $id);

        $expected = null;

        $getResponse = $this->get('api/note/' . $id);
        $actual = json_decode($getResponse->getContent(), true);

        unset($actual['created_at']);
        unset($actual['updated_at']);

        $this->assertEquals($expected, $actual);

        $note = Note::find($id);
        $note->delete();
    }

    public function testCreateNote()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';

        $createResponse = $this->call('post', 'api/note/create', [], [], [], [], $data);
        $id = $createResponse->getContent();

        $dataDecoded = json_decode($data);

        $results = [
            'title' => $dataDecoded->title,
            'note' => $dataDecoded->note,
            'user_id' => 0,
        ];

        $this->assertDatabaseHas('notes', $results, 'mysql');

        $note = Note::find($id);
        $note->delete();
    }

    public function testCreateNoteReturnsId()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';

        $response = $this->call('post', 'api/note/create', [], [], [], [], $data);
        $id = $response->getContent();

        $dataDecoded = json_decode($data);

        $results = [
            'id' => $id,
            'title' => $dataDecoded->title,
            'note' => $dataDecoded->note,
            'user_id' => 0,
        ];

        $this->assertDatabaseHas('notes', $results, 'mysql');

        $note = Note::find($id);
        $note->delete();
    }

    public function testUpdateNote()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';
        $response = $this->call('post', 'api/note/create', [], [], [], [], $data);
        $id = $response->getContent();

        $data = '{"title":"THIS IS MY EDITED NOTE","note":"This is some new text for my updated note","user_id":0}';
        $this->call('post', 'api/note/update/' . $id, [], [], [], [], $data);

        $dataDecoded = json_decode($data);

        $results = [
            'title' => $dataDecoded->title,
            'note' => $dataDecoded->note,
            'user_id' => 0,
        ];

        $this->assertDatabaseHas('notes', $results, 'mysql');

        $note = Note::find($id);
        $note->delete();
    }

    public function testDeleteNote()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';

        $response = $this->call('post', 'api/note/create', [], [], [], [], $data);
        $id = $response->getContent();

        $this->call('post', 'api/note/delete/' . $id);

        $results = [
            'id' => $id,
            'is_deleted' => 1,
        ];

        $this->assertDatabaseHas('notes', $results, 'mysql');

        $note = Note::find($id);
        $note->delete();
    }
}
