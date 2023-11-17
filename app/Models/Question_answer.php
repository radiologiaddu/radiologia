<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question_answer extends Model
{
    use HasFactory;

    protected $table = 'question_answer';

    protected $fillable = [
        't_q_id',
        'answer_id',
        'cost'
    ];

    public function type_question()
    {
        return $this->hasOne(Type_question::class, 'id','t_q_id');
    }
    public function answer()
    {
        return $this->hasOne(Answer::class, 'id','answer_id');
    }
}
