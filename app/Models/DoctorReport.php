<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'status',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}

