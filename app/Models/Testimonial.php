<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar_url',
        'body',
        'profession',
        'rate'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
