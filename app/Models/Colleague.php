<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colleague extends Model
{
    use HasFactory;

    protected $table = 'colleagues';

    protected $fillable = [
        'job_id',
        'name'
    ];
}
