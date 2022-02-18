<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSocialMediaAccount>
 */
class UserSocialMediaAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $socialMediaWebsites = [
            'Facebook',
            'Twitter',
            'Instagram',
            'LinkedIn',
            'Gmail'
        ];

        return [
            'name' => $socialMediaWebsites[rand(0, 4)],
            'email' => $this->faker->unique()->safeEmail(),
            'url' => $this->faker->url()
        ];
    }
}
