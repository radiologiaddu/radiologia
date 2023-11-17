<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'user_id',
        'paternalSurname',
        'maternalSurname',
        'alias',
        'title',
        'phone',
        'birthday',
        'gender',
        'specialty',
        'photo',
        'color',
    ];

    //Relación a la table user
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }

    public function studies(){
        return $this->hasMany(Study::class,'doctor_id')->orderBy('created_at', 'DESC');
    } 
}
