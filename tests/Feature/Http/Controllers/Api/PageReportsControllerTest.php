<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\PageReport;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageReportsControllerTest extends TestCase
{   
    /**
     * test
     */
    public function user_can_view_page_report()
    {
        $pageReport = PageReport::factory()->create();

        $response = $this->get('/api/page-report/' . $pageReport->id);
        
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'views',
                'sent_mails',
                'likes',
                'projects'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function guest_user_can_add_likes()
    {
        $pageReport = PageReport::factory()->create();

        $response = $this->put('/api/page-report/likes/' . $pageReport->id);

        $pageReportUpdated = PageReport::find($pageReport->id);

        $this->assertEquals($pageReportUpdated->likes, $pageReport->likes + 1);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'views',
                'sent_mails',
                'likes',
                'projects'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }

    /**
     * test
     */
    public function views_can_be_incremented()
    {
        $pageReport = PageReport::factory()->create();
        $response = $this->put('/api/page-report/views/' . $pageReport->id);

        $pageReportUpdated = PageReport::find($pageReport->id);

        $this->assertEquals($pageReportUpdated->views, $pageReport->views + 1);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'views',
                'sent_mails',
                'likes',
                'projects'
            ],
            'message',
            'status',
            'status_message'
        ]);
    }
}
