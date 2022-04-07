<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'website_url',
        'title',
        'description',
        'client_feedback'
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($project) {
            PageReport::first()->increment('project');
        });
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectSubImage::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::get(
            get: fn ($value) => Carbon::parse($value)->format('M d, Y')
        );
    }
}
