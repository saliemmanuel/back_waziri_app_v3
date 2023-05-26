<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_facture',
        'mensualite_facture',
        'montant_verser',
        'reste_facture',
        'statut_facture',
        'impayes',
        'id_abonne',
        'id_type_abonnement',
        'id_chef_secteur',
    ];
}
