<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursal = new Sucursal();
        $sucursal->nombre = 'DELICIAS';
        $sucursal->direccion = '';
        $sucursal->telefono = '(123)456-78-90';
        $sucursal->comentarios = 'Sucursal principal';
        $sucursal->emisor_id = 1;
        $sucursal->save();
        
        // $sucursal = new Sucursal();
        // $sucursal->nombre = 'ALLENDE';
        // $sucursal->direccion = 'Avenida Allende, Chihuahua, Mexico';
        // $sucursal->telefono = '(123)456-78-90';
        // $sucursal->comentarios = 'Sucursal de prueba';
        // $sucursal->save();

        // $sucursal = new Sucursal();
        // $sucursal->nombre = 'EMILIANO';
        // $sucursal->direccion = 'Blvd Emiliano Zapata, Chihuahua, Mexico';
        // $sucursal->telefono = '(123)456-78-90';
        // $sucursal->comentarios = 'Sucursal de prueba';
        // $sucursal->save();
    }
}
