<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageReport;

class PageReportsController extends Controller
{
    public function incrementLike()
    {
        PageReport::first()
            ->increment('likes');

        return $this->success();
    }

    public function incrementViews()
    {
        PageReport::first()
            ->increment('views');

        return $this->success();
    }

    public function incrementEmailSent()
    {
        PageReport::first()
            ->increment('views');

        return $this->success();
    }
}
