<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAbonnementModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "designation_type_abonnement",
        "montant",
        "nombre_chaine",
        "id_initiateur"
    ];
}
