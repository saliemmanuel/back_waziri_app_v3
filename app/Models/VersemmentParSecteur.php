<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersemmentParSecteur extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom_secteur",
        "nom_chef_secteur",
        "somme_verser",
        "date_versement",
        "id_secteur",
        "id_chef_secteur"
    ];
}
