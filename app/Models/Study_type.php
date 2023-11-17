<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study_type extends Model
{
    use HasFactory;

    protected $table = 'study_type';

    protected $fillable = [
        'study_id',
        'type_id',
    ];

    public function type_question(){
        return $this->hasMany(Type_question::class,'s_t_id')->orderBy('id', 'ASC');
    } 
    public function study()
    {
        return $this->hasOne(Study::class, 'id','study_id');
    }
    public function type()
    {
        return $this->hasOne(Type::class, 'id','type_id');
    }
}
