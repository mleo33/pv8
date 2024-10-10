<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taecel_credencials')->insert([
            'key' => '906744a50ee62d8aba33cb8c2f64a765',
            'nip' => '53aca71cdafe32d3e56233836249c95b',
            'balance' => 0,
        ]);
    }
}
