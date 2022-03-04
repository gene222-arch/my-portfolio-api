<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'views',
        'sent_mails',
        'likes',
        'projects'
    ];

    public $timestamps = false;
}
