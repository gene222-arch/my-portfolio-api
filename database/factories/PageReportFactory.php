<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PageReport>
 */
class PageReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'views' => $this->faker->randomDigit(),
            'sent_mails' => $this->faker->randomDigit(),
            'likes' => $this->faker->randomDigit()
        ];
    }
}
