<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageReport;

class PageReportsController extends Controller
{
    public function show(PageReport $pageReport)
    {
        return $this->success('OK', $pageReport);
    }

    public function incrementLikes(PageReport $pageReport)
    {
        $pageReport->increment('likes');

        return $this->success('Like incremented successfully.', $pageReport);
    }

    public function incrementViews(PageReport $pageReport)
    {
        $pageReport->increment('views');

        return $this->success('Views incremented successfully.', $pageReport);
    }
}
