<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplateInspection extends Model
{
    protected $fillable = [
        'chief_complains', 'on_examinations', 'provisional_diagnosis', 'differential_diagnosis', 'lab_workup', 'advices'
    ];
}
