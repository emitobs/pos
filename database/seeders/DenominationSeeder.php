<?php

namespace Database\Seeders;

use App\Models\Denomination;
use Illuminate\Database\Seeder;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '20'
        ]);
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '50'
        ]);
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '100'
        ]);
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '200'
        ]);
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '500'
        ]);
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '1000'
        ]);
        Denomination::create([
            'type' => 'BILLETE',
            'value' => '2000'
        ]);
    }
}
