<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CFDI;

class cfdiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cfdi1 = CFDI::create([
            'key_cfdi' => 'G01',
            'cfdi' => 'Adquisición de mercancías'
        ]);
        $cfdi2 = CFDI::create([
            'key_cfdi' => 'G02',
            'cfdi' => 'Devoluciones, descuentos o bonificaciones'
        ]);
        $cfdi3 = CFDI::create([
            'key_cfdi' => 'G03',
            'cfdi' => 'Gastos en general'
        ]);
        $cfdi4 = CFDI::create([
            'key_cfdi' => 'I01',
            'cfdi' => 'Construcciones'
        ]);
        $cfdi5 = CFDI::create([
            'key_cfdi' => 'I02',
            'cfdi' => 'Mobiliario y equipo de oficina por inversiones'
        ]);
        $cfdi6 = CFDI::create([
            'key_cfdi' => 'I03',
            'cfdi' => 'Equipo de transporte'
        ]);
        $cfdi7 = CFDI::create([
            'key_cfdi' => 'I04',
            'cfdi' => 'Equipo de cómputo y accesorios'
        ]);
        $cfdi8 = CFDI::create([
            'key_cfdi' => 'I05',
            'cfdi' => 'Dados, troqueles, moldes, matrices y herramental'
        ]);
        $cfdi9 = CFDI::create([
            'key_cfdi' => 'I06',
            'cfdi' => 'Comunicaciones telefónicas'
        ]);
        $cfdi10 = CFDI::create([
            'key_cfdi' => 'I07',
            'cfdi' => 'Comunicaciones satelitales'
        ]);
        $cfdi11 = CFDI::create([
            'key_cfdi' => 'I08',
            'cfdi' => 'Otra maquinaria y equipo'
        ]);
        $cfdi12 = CFDI::create([
            'key_cfdi' => 'D01',
            'cfdi' => 'Honorarios médicos, dentales y gastos hospitalarios.'
        ]);
        $cfdi13 = CFDI::create([
            'key_cfdi' => 'D02',
            'cfdi' => 'Gastos médicos por incapacidad o discapacidad'
        ]);
        $cfdi14 = CFDI::create([
            'key_cfdi' => 'D03',
            'cfdi' => 'Gastos funerales'
        ]);
        $cfdi15 = CFDI::create([
            'key_cfdi' => 'D04',
            'cfdi' => 'Donativos'
        ]);
        $cfdi16 = CFDI::create([
            'key_cfdi' => 'D05',
            'cfdi' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).'
        ]);
        $cfdi17 = CFDI::create([
            'key_cfdi' => 'D06',
            'cfdi' => 'Aportaciones voluntarias al SAR.'
        ]);
        $cfdi18 = CFDI::create([
            'key_cfdi' => 'D07',
            'cfdi' => 'Primas por seguros de gastos médicos.'
        ]);
        $cfdi19 = CFDI::create([
            'key_cfdi' => 'D08',
            'cfdi' => 'Gastos de transportación escolar obligatoria.'
        ]);
        $cfdi20 = CFDI::create([
            'key_cfdi' => 'D09',
            'cfdi' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.'
        ]);
        $cfdi21 = CFDI::create([
            'key_cfdi' => 'D10',
            'cfdi' => 'Pagos por servicios educativos (colegiaturas)'
        ]);
        $cfdi22 = CFDI::create([
            'key_cfdi' => 'P01',
            'cfdi' => 'Por definir'
        ]);
    }
}
