<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;

class costDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers = Answer::all();
        foreach($answers as $answer){
            $answer->costDoctor = $answer->cost;
            $answer->save();
        }
    }
}
