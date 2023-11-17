<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Nach Díaz',
            'email' => 'nach.diaz@happeningnm.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $user1->assignRole('SuperAdministrador');

        $user2 = User::create([
            'name' => 'Test SuperAdmin',
            'email' => 'a2ronlopezsanchez@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $user2->assignRole('SuperAdministrador');
    }
}
