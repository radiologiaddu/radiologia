<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'SuperAdministrador']);
        $role = Role::create(['name' => 'Administrador']);
        $role = Role::create(['name' => 'Doctor']);
        $role = Role::create(['name' => 'Hostess']);
    }
}
