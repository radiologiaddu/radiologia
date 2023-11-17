<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Doctor;
use Carbon\Carbon;

class interimDoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Doctor Interino',
            'email' => 'interino@ddu.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $user1->assignRole('Doctor');

        $doctor = Doctor::create([
            'user_id' => $user1->id,
            'paternalSurname' => ' ',
            'maternalSurname' => ' ',
            'alias' => 'Doctor Interino',
            'title' => 'Sin especificar',
            'phone' => '444-817-8729',
            'birthday' => '1990-01-01',
            'gender' => 'No binario',
            'specialty' => 'Dentista General'
        ]);
    }
}
