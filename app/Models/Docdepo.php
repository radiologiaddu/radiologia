<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docdepo extends Model
{
    use HasFactory;

    protected $table = 'docdepos';

    protected $fillable = [
        'name',
        'paternalSurname',
        'maternalSurname',
        'birthday',
        'gender',
        'phone',
        'email',
        'rfc',
        'specialty',
        'alias'
    ];

    public function cedula(){
        return $this->hasMany(Cedula::class,'docdepo_id')->orderBy('order', 'ASC');
    } 

    public function career(){
        return $this->hasOne(Career::class,'docdepo_id');
    } 

    public function jobs(){
        return $this->hasMany(Job::class,'docdepo_id');
    } 

    public function networks(){
        return $this->hasMany(Social_Network::class,'docdepo_id');
    }     
}
