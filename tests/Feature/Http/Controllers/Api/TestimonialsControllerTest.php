<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\PageReport;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TestimonialsControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * test
     */
    public function user_can_get_testimonials()
    {
        Testimonial::factory()
            ->count(5)
            ->create();

        $this->get('/api/testimonials')
            ->assertSuccessful()
            ->assertJsonStructure([
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

        $this->get("/api/testimonials/{$testimonial->id}")
            ->assertSuccessful()
            ->assertJsonStructure([
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
        $pageReportOld = PageReport::first();

        $data = [
            'name' => $this->faker()->name() . time(),
            'avatar_url' => $this->faker()->imageUrl(),
            'body' => $this->faker()->sentence(),
            'profession' => $this->faker()->jobTitle(),
            'rate' => rand(0, 5)
        ];

        $this->post('/api/testimonials', $data)
            ->assertCreated()
            ->assertJsonStructure([
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

        $this->assertEquals(PageReport::first()->testimonials, ($pageReportOld->testimonials + 1));
    }

    /**
     * test
     */
    public function user_can_upload_an_avatar()
    {
        Storage::fake('s3');
        $avatar = UploadedFile::fake()->image('avatarsssssss.jpg');

        $response = $this->post('/api/testimonials/upload-avatar', [
            'avatar' => $avatar
        ])
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'url'
                ],
                'message',
                'status',
                'status_message'
            ]);

        $path = str($response['data']['url'])->replace('/storage', '');
        Storage::disk('s3')->assertExists($path);
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
        $pageReportOld = PageReport::first();

        $ids = [
            $testimonialOne->id,
            $testimonialTwo->id
        ];

        $data = [
            'testimonial_ids' => $ids
        ];

        $response = $this->delete('/api/testimonials', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data',
            'message',
            'status',
            'status_message'
        ]);

        $this->assertEquals(PageReport::first()->testimonials, ($pageReportOld->testimonials - count($ids)));
    }
}
