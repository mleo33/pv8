<?php

namespace Database\Seeders;

use App\Http\Livewire\Equipos;
use App\Http\Livewire\Usuarios;
use App\Models\Categoria;
use App\Models\ClaveProducto;
use App\Models\ClaveUnidad;
use Illuminate\Database\Seeder;

use App\Models\Cliente;
use App\Models\Emisor;
use App\Models\Familia;
use App\Models\Inventario;
use App\Models\Marca;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\Usd;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        ClaveProducto::create([
            'clave' => '01010101',
            'nombre' => 'No existe en el catálogo',
        ]);
        ClaveUnidad::create([
            'clave' => 'H87',
            'nombre' => 'Pieza',
        ]);

        Emisor::create([
            'nombre' => 'Compuhipermegared',
            'rfc' => 'TEST010203001',
            'regimen_fiscal' => '601',
            'lugar_expedicion' => '33000',
            'serie' => 'A',
            'no_certificado' => '20001000000300022824',
            'clave_certificado' => '12345678a',
            'fd_user' => 'OIGA890528D33',
            'fd_pass' => 'contRa$3na',
            'cer' => '',
            'key' => '',
            'pem' => '',
            'pfx' => '',
        ]);

        $this->call(SucursalSeeder::class);
        
        $user = new User(
        [
            'name' => 'Alejandro Fernandez',
            'email' => 'testmail@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123'),
            'sucursal_default' => 1,
            'remember_token' => '',
        ]);
        $user->save();

        Usd::create([
            'cotizacion' => 22.10,
            'updated_by' => 1,
        ]);
        
        if(env('APP_ENV') == 'local')
        {
            $this->call(TestSeeder::class);
        }
        
        $this->call(RecargaSeeder::class);

        // $superUser = User::find(1);
        // $superUser->assignRole('programador');


    }
}
