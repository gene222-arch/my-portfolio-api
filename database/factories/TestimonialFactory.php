<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name('Male'),
            'body' => $this->faker->sentence(),
            'profession' => $this->faker->unique()->jobTitle(),
            'rate' => $this->faker->rand(0, 5)
        ];
    }
}
