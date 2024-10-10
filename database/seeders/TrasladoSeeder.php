<?php

namespace Database\Seeders;

use App\Models\Traslado;
use Illuminate\Database\Seeder;

class TrasladoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Traslado::create([
            'destino' => 'DELICIAS',
            'sencillo' => 2500,
            'redondo' => 5000,
        ]);

        Traslado::create([
            'destino' => 'CUAUHTEMOC',
            'sencillo' => 1250,
            'redondo' => 2500,
        ]);

        Traslado::create([
            'destino' => 'PARRAL',
            'sencillo' => 4000,
            'redondo' => 8000,
        ]);

        Traslado::create([
            'destino' => 'CD JUAREZ',
            'sencillo' => 5000,
            'redondo' => 10000,
        ]);
    }
}
