<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterielModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation_materiel',
        'prix_materiel',
        'image_materiel',
        'date_achat_materiel',
        'facture_materiel',
        'statut_materiel'
    ];
}
