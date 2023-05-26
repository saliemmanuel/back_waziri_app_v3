<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbonneModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "nom_abonne",
        "prenom_abonne",
        "cni_abonne",
        "telephone_abonne",
        "description_zone_abonne",
        "secteur_abonne",
        "id_chef_secteur",
        "type_abonnement",
        'id_type_abonnement'
    ];
}
