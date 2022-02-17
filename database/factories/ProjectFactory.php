<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->title() . time(),
            'description' => $this->faker->unique()->sentence(),
            'image_url' => $this->faker->unique()->image(),
            'client_feedback' => $this->faker->sentence()
        ];
    }
}
