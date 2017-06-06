<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
        $response = $this->get('api/notes');
    }

    public function testGetNote()
    {
        $response = $this->get('api/note/1');
    }

    public function testCreateNote()
    {
        $data = '{"title":"HELLO THIS IS MY NOTE","note":"Here is some text to put in my note","user_id":0}';

        $this->call('post', 'api/note/create', [], [], [], [], $data);

        $dataDecoded = json_decode($data);

        $results = [
            'title' => $dataDecoded->title,
            'note' => $dataDecoded->note,
            'user_id' => 0,
        ];

        $this->assertDatabaseHas('notes', $results, 'mysql');
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
    }
}
