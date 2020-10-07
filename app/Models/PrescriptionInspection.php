<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrescriptionInspection extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'chief_complains', 'on_examinations', 'provisional_diagnosis', 'differential_diagnosis', 'lab_workup', 'advices'
    ];
}
