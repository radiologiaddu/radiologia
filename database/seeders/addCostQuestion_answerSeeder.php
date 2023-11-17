<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question_answer;
class addCostQuestion_answerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $q_answers = Question_answer::all();
        foreach($q_answers as $q_answer){
            if($q_answer->created_at > '2023-05-27'){
                $flag_internal = $q_answer->type_question->study_type->study->internal;
                if($flag_internal){
                    $q_answer->cost = $q_answer->answer->cost;
                }else{
                    $q_answer->cost = $q_answer->answer->costDoctor;
                }
            }else{
                $q_answer->cost = $q_answer->answer->cost;
            }    
            $q_answer->save();
        }
    }
}
