<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation_charge',
        'description_charge',
        'date_charge',
        'somme_verser'
    ];
}
