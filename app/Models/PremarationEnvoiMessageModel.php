<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremarationEnvoiMessageModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation_message',
        'corps_message',
        'numeros',
        'statut_message'
    ];
}
