<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use App\Mail\MailAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test
     */
    public function user_can_send_mail()
    {
        Mail::fake();

        $data = [
            'email' => 'genephillip222@gmail.com',
            'message' => 'Heyheyhey',
            'name' => 'Gene Phillip D. Artista'
        ];

        $response = $this->post('/api/mail-admin', $data);  

        $this->assertDatabaseHas('emails', $data);
        $response->assertSuccessful();
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
    public function mail_can_be_send()
    {
        Mail::fake();

        Mail::send(new MailAdmin(
            'genephillip222@gmail.com',
            'Hello World!',
            'Gene Phillip'
        ));

        Mail::assertSent(MailAdmin::class);
    }
}
