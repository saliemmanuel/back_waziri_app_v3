<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeAdministrationModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "code_admin",
        "remember_code_admin",
        'id_admin'
    ];

    protected $hidden = [
        'remember_code_admin'
    ];
}
