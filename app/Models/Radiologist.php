<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radiologist extends Model
{
    use HasFactory;

    protected $table = 'radiologists';

    protected $fillable = [
        'name',
        'status'
    ];
}
