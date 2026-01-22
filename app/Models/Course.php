<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'slug',
        'published_at',
        'moodle_course_id',
        'moodle_shortname',
        'created_by',
        'prerequisites',
        'duration',
        'intro_video_url',
        'thumbnail_path'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'moodle_course_id' => 'integer',
        'prerequisites' => 'array',
        'duration' => 'integer',
    ];
}
