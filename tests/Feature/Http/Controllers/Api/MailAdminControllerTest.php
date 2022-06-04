<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use App\Mail\MailAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /**
     * test
     */
    public function user_can_send_mail()
    {
        $data = [
            'email' => 'genephillip222@gmail.com',
            'message' => 'Heyheyhey',
            'name' => 'Gene Phillip D. Artista'
        ];

        $this->post('/api/mail-admin', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
                'message',
                'status',
                'status_message'
            ]);
            
        $this->assertDatabaseHas('emails', $data);
    }

    /**
     * test
     */
    public function mail_can_be_send()
    {
        Mail::send(new MailAdmin(
            'genephillip222@gmail.com',
            'Hello World!',
            'Gene Phillip'
        ));

        Mail::assertQueued(MailAdmin::class);
    }
}
