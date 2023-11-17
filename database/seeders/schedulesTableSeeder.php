<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class schedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule1 = Schedule::create([
            'kind' => 'VERANO',
            'start' => 0,
            'end' => 0
        ]);

        $schedule2 = Schedule::create([
            'kind' => 'INVIERNO',
            'start' => 01,
            'end' => 12
        ]);
    }
}
