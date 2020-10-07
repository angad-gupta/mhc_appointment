<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionDrug extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'type','name','strength','dose','advice'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
