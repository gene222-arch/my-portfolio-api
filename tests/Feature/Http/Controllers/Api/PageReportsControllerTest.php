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
        $this->actingAs(User::find(1), 'api');

        $response = $this->get('/api/page-report');
        
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function guest_user_can_add_likes()
    {
        $pageReport = PageReport::first();

        $response = $this->put('/api/page-report/likes');

        $pageReportUpdated = PageReport::first();

        $this->assertEquals($pageReportUpdated->likes, $pageReport->likes + 1);
        $response->assertSuccessful();
    }

    /**
     * test
     */
    public function views_can_be_incremented()
    {
        $response = $this->put('/api/page-report/views');

        $response->assertSuccessful();
    }

    /**
     * test
     */
    public function sent_emails_can_be_incremented()
    {
        $response = $this->put('/api/page-report/sent-mails');

        $response->assertSuccessful();
    }

    /**
     * test
     */
    public function projects_can_be_incremented()
    {
        $response = $this->put('/api/page-report/projects');

        $response->assertSuccessful();
    }
}
