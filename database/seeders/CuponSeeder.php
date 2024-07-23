<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Doctor;

class CuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener todos los doctores
        $doctores = Doctor::all();

        // Arreglos para los cupones
        $cupones = [
            'Cupon10_1' => 'Activo',
            'Cupon10_2' => 'Activo',
            'Cupon10_3' => 'Usado',
        ];

        // Insertar o actualizar los cupones para cada doctor
        foreach ($doctores as $doctor) {
            foreach ($cupones as $nombre => $estatus) {
                DB::table('cupones')->updateOrInsert(
                    [
                        'id_doctor' => $doctor->id,
                        'nombre_cupon' => $nombre
                    ],
                    [
                        'estatus' => $estatus,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }
}
