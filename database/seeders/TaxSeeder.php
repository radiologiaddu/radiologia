<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tax1 = Tax::create([
            'key_regimen' => '601',
            'regimen' => 'General de Ley Personas Morales'
        ]);
        $tax3 = Tax::create([
            'key_regimen' => '603',
            'regimen' => 'Personas Morales con Fines no Lucrativos'
        ]);
        $tax5 = Tax::create([
            'key_regimen' => '605',
            'regimen' => 'Sueldos y Salarios e Ingresos Asimilados a Salarios'
        ]);
        $tax6 = Tax::create([
            'key_regimen' => '606',
            'regimen' => 'Arrendamiento'
        ]);
        $tax7 = Tax::create([
            'key_regimen' => '607',
            'regimen' => 'Régimen de Enajenación o Adquisición de Bienes'
        ]);
        $tax8 = Tax::create([
            'key_regimen' => '608',
            'regimen' => 'Demás ingresos'
        ]);
        $tax10 = Tax::create([
            'key_regimen' => '610',
            'regimen' => 'Residentes en el Extranjero sin Establecimiento Permanente en México'
        ]);
        $tax11 = Tax::create([
            'key_regimen' => '611',
            'regimen' => 'Ingresos por Dividendos (socios y accionistas)'
        ]);
        $tax12 = Tax::create([
            'key_regimen' => '612',
            'regimen' => 'Personas Físicas con Actividades Empresariales y Profesionales'
        ]);
        $tax14 = Tax::create([
            'key_regimen' => '614',
            'regimen' => 'Ingresos por intereses'
        ]);
        $tax15 = Tax::create([
            'key_regimen' => '615',
            'regimen' => 'Régimen de los ingresos por obtención de premios'
        ]);
        $tax16 = Tax::create([
            'key_regimen' => '616',
            'regimen' => 'Sin obligaciones fiscales'
        ]);
        $tax20 = Tax::create([
            'key_regimen' => '620',
            'regimen' => 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos'
        ]);
        $tax21 = Tax::create([
            'key_regimen' => '621',
            'regimen' => 'Incorporación Fiscal'
        ]);
        $tax22 = Tax::create([
            'key_regimen' => '622',
            'regimen' => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras'
        ]);
        $tax23 = Tax::create([
            'key_regimen' => '623',
            'regimen' => 'Opcional para Grupos de Sociedades'
        ]);
        $tax24 = Tax::create([
            'key_regimen' => '624',
            'regimen' => 'Coordinados'
        ]);
        $tax25 = Tax::create([
            'key_regimen' => '625',
            'regimen' => 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas'
        ]);
        $tax26 = Tax::create([
            'key_regimen' => '626',
            'regimen' => 'Régimen Simplificado de Confianza'
        ]);
    }
}
