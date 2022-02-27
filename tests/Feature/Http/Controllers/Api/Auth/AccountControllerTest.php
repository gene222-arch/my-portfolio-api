<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserSocialMediaAccount;
use Illuminate\Foundation\Testing\WithFaker;

class AccountControllerTest extends TestCase
{
    use WithFaker;

    /**
     * test
     */
    public function user_can_update_account_details()
    {
        $user = User::factory()
            ->has(UserDetail::factory(), 'details')
            ->has(UserSocialMediaAccount::factory()->count(3), 'socialMediaAccounts')
            ->create();

        $this->actingAs(User::find($user->id), 'api');

        $data = [
            'phone_number' => $this->faker()->unique()->phoneNumber(),
            'address' => $this->faker()->address()
        ];

        $response = $this->put("/api/account/details/{$user->id}", $data);

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
    public function user_can_update_social_media_accounts()
    {
        $user = User::factory()
            ->has(UserDetail::factory(), 'details')
            ->has(UserSocialMediaAccount::factory(), 'socialMediaAccounts')
            ->create();

        $this->actingAs(User::find($user->id), 'api');

        $socialMediaWebsites = [
            'Facebook',
            'Twitter',
            'Instagram',
            'LinkedIn',
            'Gmail'
        ];

        $data = [
            'name' => $socialMediaWebsites[rand(0, 4)],
            'email' => $this->faker()->unique()->email(),
            'url' => $this->faker()->url()
        ];

        $response = $this->put("/api/account/social-media/{$user->id}", $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}