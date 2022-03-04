<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageReportsControllerTest extends TestCase
{
    /**
     * test
     */
    public function guest_user_can_add_likes()
    {
        $response = $this->put('/api/page-report/likes');

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
}
