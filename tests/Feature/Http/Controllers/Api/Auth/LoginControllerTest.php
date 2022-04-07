<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserAddress;
use App\Models\UserSocialMediaAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test
     */
    public function user_can_login()
    {
        $user = User::factory()
            ->has(UserAddress::factory(), 'address')
            ->has(UserDetail::factory(), 'details')
            ->has(UserSocialMediaAccount::factory()->count(3), 'socialMediaAccounts')
            ->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
            'remember_me' => false
        ];

        $this->post('/api/auth/login', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'token_type',
                    'expired_at'
                ],
                'message',
                'status',
                'status_message'
            ]);

        $this->assertAuthenticated();
    }

    /**
     * test
     */
    public function user_can_log_out()
    {
        $user = User::factory()
            ->has(UserAddress::factory(), 'address')
            ->has(UserDetail::factory(), 'details')
            ->has(UserSocialMediaAccount::factory()->count(3), 'socialMediaAccounts')
            ->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
            'remember_me' => false
        ];

        #Login
        $loginResponse = $this->post('/api/auth/login', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
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
        $this->post('/api/auth/logout', [], $headers)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
                'message',
                'status',
                'status_message'
            ]);
    }
}
