<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social_Network extends Model
{
    use HasFactory;

    protected $table = 'social_networks';

    protected $fillable = [
        'docdepo_id',
        'type',
        'name',
        'facebook',
        'instagram',
        'tiktok',
        'linkedin',
        'website',
        'doctoralia'
    ];
}
