<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;

    public $timestamps = true;
    //Seguimiento a los timestamps

    protected $table = 'cupones';

    protected $fillable = [
        'id_doctor',
        'nombre_cupon',
        'estatus',
        // ... otras columnas ...
    ];
}
