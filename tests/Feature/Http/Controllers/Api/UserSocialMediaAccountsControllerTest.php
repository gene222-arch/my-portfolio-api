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
    use RefreshDatabase;

    /**
     * test
     */
    public function user_can_get_social_media_accounts()
    {
        User::factory()
            ->has(UserSocialMediaAccount::factory()->count(5), 'socialMediaAccounts')
            ->create();

        $this->get('/api/social-media-accounts')
            ->assertSuccessful()
            ->assertJsonStructure([
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

        $this->post('/api/social-media-accounts', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data',
                'message',
                'status',
                'status_message'
            ]);

        $this->assertDatabaseHas('user_social_media_accounts', $data);
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

        $this->put("/api/social-media-accounts/{$socialMediaAccountID}", $data)
            ->assertSuccessful()
            ->assertJsonStructure([
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

        $socialMediaAccounts = $user
            ->socialMediaAccounts
            ->map(
                fn ($socMed) => $socMed->only('id')
            )
            ->toArray();

        $data = [
            'ids' => $user->socialMediaAccounts->map->id->toArray()
        ];

        $this->delete('/api/social-media-accounts', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
                'message',
                'status',
                'status_message'
            ]);

        $this->assertDatabaseMissing(UserSocialMediaAccount::class, $socialMediaAccounts);
    }
}
