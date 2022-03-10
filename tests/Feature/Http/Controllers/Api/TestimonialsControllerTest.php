<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestimonialsControllerTest extends TestCase
{
    use WithFaker;

    /**
     * test
     */
    public function user_can_get_testimonials()
    {
        Testimonial::factory()
            ->count(5)
            ->create();

        $response = $this->get('/api/testimonials');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'avatar_url',
                    'body',
                    'profession',
                    'rate'
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
    public function user_can_get_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->get("/api/testimonials/{$testimonial->id}");

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'avatar_url',
                'body',
                'profession',
                'rate'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

     /**
     * test
     */
    public function user_can_create_testimonial()
    {
        $data = [
            'name' => $this->faker()->name() . time(),
            'avatar_url' => $this->faker()->imageUrl(),
            'body' => $this->faker()->sentence(),
            'profession' => $this->faker()->jobTitle(),
            'rate' => rand(0, 5)
        ];

        $response = $this->post('/api/testimonials', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'avatar_url',
                'body',
                'profession',
                'rate'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

   /**
     * test
     */
    public function user_can_update_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $data = [
            'name' => $this->faker()->name() . time(),
            'avatar_url' => $this->faker()->imageUrl(),
            'body' => $this->faker()->sentence(),
            'profession' => $this->faker()->jobTitle(),
            'rate' => rand(0, 5)
        ];

        $response = $this->put("/api/testimonials/{$testimonial->id}", $data);

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
    public function user_can_destroy_testimonial_or_testimonials()
    {
        $testimonialOne = Testimonial::factory()->create();
        $testimonialTwo = Testimonial::factory()->create();

        $data = [
            'testimonial_ids' => [
                $testimonialOne->id,
                $testimonialTwo->id
            ]
        ];

        $response = $this->delete('/api/testimonials', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);
    }
}
