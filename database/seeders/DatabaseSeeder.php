<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\DoctorReport;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Lógica para llenar doctor_reports
        $users = User::all();

        foreach ($users as $user) {
            $doctor = Doctor::where('user_id', $user->id)->first();

            if ($doctor) {
                DoctorReport::updateOrCreate(
                    ['doctor_id' => $doctor->id],
                    [
                        'user_id' => $user->id,
                        'status' => 'Activo', // Siempre Activo
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }
}
