<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number'
    ];

    public $timestamps = false;

    protected $hidden = [
        'id',
        'user_id'
    ];
}
