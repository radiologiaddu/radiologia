<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'question',
        'kind',
        'type_id',
        'note',
        'class_note'
    ];

    public function answer(){
        return $this->hasMany(Answer::class,'question_id');
    } 

    public function type()
    {
        return $this->hasOne(Type::class, 'id','type_id');
    }

    public function dependency(){
        return $this->hasMany(Dependency::class,'question_id');
    } 
}
