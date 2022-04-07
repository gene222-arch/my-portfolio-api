<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\PageReport;
use App\Models\Project;
use App\Models\ProjectSubImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectsControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * test
     */
    public function user_can_get_projects()
    {
        Project::factory()
            ->has(ProjectSubImage::factory()->count(3), 'images')
            ->create();

        $this->get('/api/projects')
            ->assertStatus(200)
            ->assertJsonStructure([
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

        $this->get("/api/projects/{$project->id}")
            ->assertSuccessful()
            ->assertJsonStructure([
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
        $pageReportOld = PageReport::first();

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

        $this->post('/api/projects', $data)
            ->assertCreated()
            ->assertJsonStructure([
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

        $pageReportUpdated = PageReport::first();

        $this->assertEquals($pageReportUpdated->projects, ($pageReportOld->projects + 1));
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

        $this->put("/api/projects/{$project->id}", $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' ,
                'message',
                'status',
                'status_message'
            ]);
    }

    /**
     * test
     */
    public function user_can_upload_image()
    {
        Storage::fake('s3');
        $image = UploadedFile::fake()->image('HEYHEYHEY.jpg');
        $data = [
            'image' => $image
        ];

        $response = $this->post('/api/projects/image-upload', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'url'
                ],
                'message',
                'status',
                'status_message'
            ]);

        $s3FilePath = str($response['data']['url'])->replace('storage/', '');
        Storage::disk('s3')->assertExists($s3FilePath);
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

        $pageReportOld = PageReport::first();

        $ids = [
            $projectOne->id,
            $projectTwo->id
        ];

        $data = [
            'project_ids' => $ids
        ];

        $this->delete('/api/projects', $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' ,
                'message',
                'status',
                'status_message'
            ]);
        
        $pageReportUpdated = PageReport::first();

        $this->assertDatabaseMissing(Project::class, [
            [
                'id' => $projectOne->id
            ],
            [
                'id' => $projectTwo->id
            ]
        ]);
        $this->assertEquals($pageReportUpdated->projects, ($pageReportOld->projects - count($ids)));
    }
}
