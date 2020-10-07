<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'phone', 'mail', 'address', 'google_map', 'fb_link', 'twitter_link', 'linked_in_link', 'instragram_link'
    ];
}
