<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_question extends Model
{
    use HasFactory;

    protected $table = 'type_questions';

    protected $fillable = [
        's_t_id',
        'question_id',
        'answer',
    ];

    public function question_answer(){
        return $this->hasMany(Question_answer::class,'t_q_id')->orderBy('id', 'ASC');
    } 
    public function study_type()
    {
        return $this->hasOne(Study_type::class, 'id','s_t_id');
    }
    public function question()
    {
        return $this->hasOne(Question::class, 'id','question_id');
    }
}
