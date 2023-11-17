<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependency extends Model
{
    use HasFactory;

    protected $table = 'dependencies';

    protected $fillable = [
        'question_id',
        'answer_id'
    ];

    public function question()
    {
        return $this->hasOne(Question::class, 'id','question_id');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'id','answer_id');
    }
}
