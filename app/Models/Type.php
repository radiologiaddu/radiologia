<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = [
        'type','class_note','note'
    ];

    public function questions(){
        return $this->hasMany(Question::class,'type_id')->orderBy('id', 'ASC');
    } 
}
