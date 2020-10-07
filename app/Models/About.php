<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'about_us' ,'about_us_video','about_us_image','opening_hours','image_or_video'
    ];
}
