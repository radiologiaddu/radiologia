<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    protected $fillable = [
        'docdepo_id',
        'type',
        'address',
        'location',
        'phone',
        'name',
        'nameAssistant',
        'nameDoctor'
    ];

    
    public function clinicas(){
        return $this->hasMany(Office::class,'job_id');
    } 
    public function cities(){
        return $this->hasMany(City::class,'job_id');
    } 
    public function colleagues(){
        return $this->hasMany(Colleague::class,'job_id');
    } 
}
