<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCall extends Model
{
    protected $table = 'video_call';
    protected $fillable=[
        'appointment_id','patient_id','doctor_id','status','call_duration','room_id','created_at','updated_at'
    ];
}
