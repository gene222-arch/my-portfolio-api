<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * test
     */
    public function user_can_login()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
            'remember_me' => false
        ];

        $response = $this->post('/api/auth/login', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expired_at'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_log_out()
    {
        $user = User::factory()->create();
        $user = User::find($user->id);

        $data = [
            'email' => $user->email,
            'password' => 'password',
            'remember_me' => false
        ];

        #Login
        $loginResponse = $this->post('/api/auth/login', $data);
        $loginResponse->assertSuccessful();
        $loginResponse->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expired_at'
            ],
            'message',
            'status',
            'status_message'
        ]);

        $accessToken = $loginResponse->json()['data']['access_token'];
        $headers = [
            'Authorization' => "Bearer {$accessToken}"
        ];

        #Logout
        $logoutResponse = $this->post('/api/auth/logout', [], $headers);
        $logoutResponse->assertSuccessful();
        $logoutResponse->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
