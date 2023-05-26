<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecteurModel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "designation_secteur",
        "description_secteur",
        "nom_chef_secteur",
        'id_chef_secteur'
    ];
}
