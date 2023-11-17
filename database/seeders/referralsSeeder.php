<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Referral;

class referralsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r1 = Referral::create([
            'name' => 'RECETA',
        ]);
        $r2 = Referral::create([
            'name' => 'PLATAFORMA',
        ]);
        $r3 = Referral::create([
            'name' => 'CAYEE',
        ]);
        $r4 = Referral::create([
            'name' => 'CEYE',
        ]);
        $r5 = Referral::create([
            'name' => 'IMADENT',
        ]);
        $r6 = Referral::create([
            'name' => 'LADEM DIGITAL',
        ]);
        $r7 = Referral::create([
            'name' => 'MIRA',
        ]);
        $r8 = Referral::create([
            'name' => 'PANODENT',
        ]);        
        $r9 = Referral::create([
            'name' => 'RADENT',
        ]);        
        $r10 = Referral::create([
            'name' => 'RADIOLAB 3D',
        ]);
        $r11 = Referral::create([
            'name' => 'ROENGEN',
        ]);
        $r12 = Referral::create([
            'name' => 'RIHE',
        ]);
        $r13 = Referral::create([
            'name' => 'UASLP',
        ]);
    }
}
