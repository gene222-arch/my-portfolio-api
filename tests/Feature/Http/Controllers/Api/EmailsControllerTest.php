<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test
     */
    public function user_can_get_emails()
    {
        Email::factory()->count(3)->create();

        $this->get('/api/emails')
            ->assertSuccessful()
            ->assertJsonStructure([
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
        
        $data = [
            'ids' => [
                $emailID
            ]
        ];

        $this->delete("/api/emails", $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
                'message',
                'status',
                'status_message'
            ]);

        $this->assertSoftDeleted('emails', [
            'id' => $emailID
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

        $data = [
            'ids' => [
                $emailID
            ]
        ];

        $this->put("/api/emails/restore", $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
                'message',
                'status',
                'status_message'
            ]);

        $this->assertNotSoftDeleted('emails', [
            'id' => $emailID
        ]);
    }
}
