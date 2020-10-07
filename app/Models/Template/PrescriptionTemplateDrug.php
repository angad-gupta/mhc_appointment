<?php

namespace App\Models\Template;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplateDrug extends Model
{

    protected $fillable = [
        'type','name','strength','dose','advice'
    ];



}
