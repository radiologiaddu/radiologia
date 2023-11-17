<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeTime extends Model
{
    use HasFactory;

    protected $table = 'free_times';

    protected $fillable = [
        'type',
        'radiologist_id',
        'date',
        'time',
        'duration'
    ];
}
