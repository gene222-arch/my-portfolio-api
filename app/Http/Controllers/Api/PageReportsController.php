<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageReport;

class PageReportsController extends Controller
{
    private PageReport $pageReport;

    public function __construct()
    {
        $this->pageReport = PageReport::first();
    }

    public function show(PageReport $pageReport)
    {
        return $this->success('OK', $pageReport);
    }

    public function incrementLikes()
    {
        $this->pageReport->increment('likes');

        return $this->success('Like incremented successfully.', $this->pageReport);
    }

    public function incrementViews()
    {
        $this->pageReport->increment('views');

        return $this->success('Views incremented successfully.', $this->pageReport);
    }
}
