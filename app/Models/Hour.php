<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;

    protected $table = 'hours';

    protected $fillable = [
        'start',
        'end',
        'start_time',
        'end_time',
        'schedule_id'
    ];
}
