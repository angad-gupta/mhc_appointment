<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    protected $fillable = ['full_name', 'email_address', 'subject', 'message'];

    public function replies()
    {
        return $this->hasMany(ContactQuery::class,'contact_query_id');
    }
}
