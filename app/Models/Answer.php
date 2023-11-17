<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
        'answer',
        'question_id',
        'cost',
        'study_time',
        'preparation_time',
        'exit_time',
        'costDoctor'
    ];

    public function question()
    {
        return $this->hasOne(Question::class, 'id','question_id');
    }

    public function dependency(){
        return $this->hasMany(Dependency::class,'answer_id');
    } 
}
