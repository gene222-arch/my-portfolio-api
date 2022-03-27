<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailsControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_get_emails()
    {
        Email::factory()->count(3)->create();

        $response = $this->get('/api/emails');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'email',
                    'message',
                    'updated_at',
                    'created_at',
                ]
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_destroy_email()
    {
        $email = Email::factory()->create();
        $emailID = $email->id;

        $response = $this->delete("/api/emails/{$emailID}");
        $email = Email::withTrashed()->find($emailID);
        
        $response->assertSuccessful();
        $this->assertNotNull($email->deleted_at);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_restore_email()
    {
        $email = Email::factory()->create();
        $emailID = $email->id;
        $email->delete();

        $response = $this->put("/api/emails/{$emailID}/restore");
        $email = Email::find($emailID);

        $response->assertSuccessful();
        $this->assertNull($email->deleted_at);
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
