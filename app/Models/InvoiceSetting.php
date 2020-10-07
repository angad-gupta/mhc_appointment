<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $fillable = [
        'currency_symbol','currency_name','invoice_text','address','phone','email'
    ];
}
