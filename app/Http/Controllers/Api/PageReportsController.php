<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PageReport;

class PageReportsController extends Controller
{
    public function show()
    {
        return $this->success('OK', PageReport::first());
    }

    public function incrementLikes()
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

    public function incrementSentMails()
    {
        PageReport::first()
            ->increment('views');

        return $this->success();
    }
}
