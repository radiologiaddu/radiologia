<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hour;

class HoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hour1 = Hour::create([
            'start' => 'Lunes',
            'end' => 'Viernes',
            'start_time' => '10:00',
            'end_time' => '19:00',
            'schedule_id' => 1
        ]);
        
        $hour2 = Hour::create([
            'start' => 'Sábado',
            'end' => 'Sábado',
            'start_time' => '09:00',
            'end_time' => '14:00',
            'schedule_id' => 1
        ]);

        $hour3 = Hour::create([
            'start' => 'Lunes',
            'end' => 'Viernes',
            'start_time' => '09:30',
            'end_time' => '19:00',
            'schedule_id' => 2
        ]);

        $hour4 = Hour::create([
            'start' => 'Sábado',
            'end' => 'Sábado',
            'start_time' => '09:30',
            'end_time' => '14:30',
            'schedule_id' => 2
        ]);
    }
}
