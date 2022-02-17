<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Project;
use App\Models\ProjectSubImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsControllerTest extends TestCase
{
    use WithFaker;

    /**
     * test
     */
    public function user_can_get_projects()
    {
        Project::factory()
            ->has(ProjectSubImage::factory()->count(3), 'images')
            ->create();

        $response = $this->get('/api/projects');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'description',
                    'image_url',
                    'website_url',
                    'client_feedback',
                    'updated_at',
                    'created_at',
                    'images' => [
                        [
                            'id',
                            'project_id',
                            'image_url'
                        ]
                    ]
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
    public function user_can_get_project()
    {
        $project = Project::factory()
            ->has(ProjectSubImage::factory(), 'images')
            ->create();

        $response = $this->get("/api/projects/{$project->id}");

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'image_url',
                'website_url',
                'client_feedback',
                'updated_at',
                'created_at',
                'images' => [
                    [
                        'id',
                        'project_id',
                        'image_url'
                    ]
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
    public function user_can_create_project()
    {
        $data = [
            'image_url' => $this->faker()->image(),
            'website_url' => $this->faker()->url(),
            'title' => $this->faker()->unique()->title() . time(),
            'description' => $this->faker()->sentence(),
            'client_feedback' => $this->faker()->sentence(),
            'sub_image_urls' => [
                $this->faker()->image(),
                $this->faker()->image()
            ]
        ];

        $response = $this->post('/api/projects', $data);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'image_url',
                'website_url',
                'client_feedback',
                'updated_at',
                'created_at',
                'images' => [
                    [
                        'id',
                        'project_id',
                        'image_url'
                    ]
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
    public function user_can_update_a_project()
    {
        $project = Project::factory()
            ->has(ProjectSubImage::factory(), 'images')
            ->create();

        $data = [
            'project_id' => $project->id,
            'image_url' => $this->faker()->image(),
            'website_url' => $this->faker()->url(),
            'title' => $this->faker()->unique()->title() . time(),
            'description' => $this->faker()->sentence(),
            'client_feedback' => $this->faker()->sentence(),
            'sub_image_urls' => [
                $this->faker()->image(),
                $this->faker()->image()
            ]
        ];

        $response = $this->put("/api/projects/{$project->id}", $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' ,
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function user_can_destroy_project_or_projects()
    {
        $projectOne = Project::factory()
            ->has(ProjectSubImage::factory(), 'images')
            ->create();

        $projectTwo = Project::factory()
            ->has(ProjectSubImage::factory(), 'images')
            ->create();

        $data = [
            'project_ids' => [
                $projectOne->id,
                $projectTwo->id
            ]
        ];

        $response = $this->delete('/api/projects', $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' ,
            'message',
            'status',
            'status_message'
        ]);
    }
}
