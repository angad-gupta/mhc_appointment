<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionSetting extends Model
{
    protected $fillable = [
        'show_top_left', 'top_left', 'show_top_right', 'top_right'
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::creating(function ($modal) {
            $modal->show_top_left = $modal->show_top_left == 'on' ? 1 : 0;
            $modal->show_top_right = $modal->show_top_right == 'on' ? 1 : 0;
        });

        self::updating(function ($modal) {
            $modal->show_top_left = $modal->show_top_left == 'on' ? 1 : 0;
            $modal->show_top_right = $modal->show_top_right == 'on' ? 1 : 0;
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
