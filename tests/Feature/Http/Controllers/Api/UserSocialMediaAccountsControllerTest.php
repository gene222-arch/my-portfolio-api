<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserSocialMediaAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSocialMediaAccountsControllerTest extends TestCase
{
    use WithFaker;

    /**
     * test
     */
    public function user_can_get_social_media_accounts()
    {
        User::factory()
            ->has(UserSocialMediaAccount::factory()->count(5), 'socialMediaAccounts')
            ->create();

        $response = $this->get('/api/social-media-accounts');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user_id',
                    'name',
                    'email',
                    'url'
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
    public function user_can_create_social_media_account()
    {
        $data = [
            'name' => $this->faker()->firstName(),
            'email' => $this->faker()->safeEmail(),
            'url' => $this->faker()->url()
        ];

        $response = $this->post('/api/social-media-accounts', $data);

        $response->assertCreated();
        $this->assertDatabaseHas('user_social_media_accounts', $data);
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
    public function user_can_update_social_media_account()
    {
        $user = User::factory()
            ->has(UserSocialMediaAccount::factory(), 'socialMediaAccounts')
            ->create();

        $socialMediaAccountID = $user->socialMediaAccounts->first()->id;

        $data = [
            'user_social_media_account_id' => $socialMediaAccountID,
            'name' => $this->faker()->firstName(),
            'email' => $this->faker()->safeEmail(),
            'url' => $this->faker()->url()
        ];

        $response = $this->put("/api/social-media-accounts/{$socialMediaAccountID}", $data);

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
    public function user_can_destroy_social_media_account_or_social_media_accounts()
    {
        $user = User::factory()
            ->has(UserSocialMediaAccount::factory()->count(5), 'socialMediaAccounts')
            ->create();

        $data = [
            'ids' => $user->socialMediaAccounts->map->id->toArray()
        ];

        $response = $this->delete('/api/social-media-accounts', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
