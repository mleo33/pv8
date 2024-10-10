<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\EntidadFiscal;
use App\Models\Factura;
use App\Models\Familia;
use App\Models\Marca;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(7)->create();
        Cliente::factory(80)->create();
        Proveedor::factory(80)->create();

        EntidadFiscal::create([
            'model_type' => 'App\Models\Cliente',
            'model_id' => '80',
            'razon_social' => 'PABLO NERUDA PEREZ',
            'regimen_fiscal' => '612',
            'calle' => 'Calle Siempre Viva',
            'numero' => '6903',
            'colonia' => 'INSURGENTES',
            'cp' => '72000',
            'ciudad' => 'JUAREZ',
            'estado' => 'CHIHUAHUA',
            'rfc' => 'TEST010203001',
            'correo' => 'testmail@hotmail.com',
            'comentarios' => 'FROM FRACTORY!',
        ]);

        EntidadFiscal::create([
            'model_type' => 'App\Models\Cliente',
            'model_id' => '80',
            'razon_social' => 'PABLO NERUDA PEREZ',
            'regimen_fiscal' => '612',
            'calle' => 'Calle Siempre Viva',
            'numero' => '6903',
            'colonia' => 'INSURGENTES',
            'cp' => '72000',
            'ciudad' => 'JUAREZ',
            'estado' => 'CHIHUAHUA',
            'rfc' => 'XAXX010101000',
            'correo' => 'testmail@hotmail.com',
            'comentarios' => 'FROM FRACTORY!',
        ]);

        foreach (['TRUPPER', 'MAKITA', 'TONKA', 'HONDA', 'ESTEREN', 'DEL NORTE', 'HUSKY'] as $value) {
            $marca = new Marca();
            $marca->nombre = $value;
            $marca->save();
        }

        foreach (['ANDA' => 'ANDAMIOS', 'CMPA' => 'COMPACTADORES', 'COMP' => 'COMPRESORES', 'DEMO' => 'DEMOLEDORES', 'ELEV' => 'ELEVACION', 'GENE' => 'GENERADORES', 'GRUA' => 'GRUAS',
        'MONT' => 'MONTACARGAS', 'REMO' => 'REMOLQUES', 'REVO' => 'REVOLVEDORAS', 'RODI' => 'RODILLOS', 'TABL' => 'TABLONES', 'VEHI' => 'VEHICULOS', 'VIBR' => 'VIBRADORES ', 'TALA' => 'TALADROS'] as $key => $value) {
            $familia = new Familia();
            $familia->nombre = $value;
            $familia->abreviacion = $key;
            $familia->save();
        }

        foreach (['REFACCIONES', 'PARTES', 'ACCESORIOS', 'MANGUERAS', 'TORNILLOS', 'CONSUMIBLES', 'PLASTICOS'] as $value) {
            $categoria = new Categoria();
            $categoria->nombre = $value;
            $categoria->save();
        }

        Factura::create([
            'usuario_id' => 1,
            'sucursal_id' => 1,
            'emisor_id' => 1,
            'entidad_fiscal_id' => 1,
            // 'model_id' => 1,
            // 'model_type' => 1,
            'tipo' => 'I',
            'forma_pago' => 'EFECTIVO',
            'serie' => 'A',
            'folio' => 1,
            'subtotal' => 100,
            'total' => 116,
            'uuid' => '1234-5678-9999',
            'xml' => '<XML></XML>',
            'estatus' => 'TIMBRADO',
            'comentarios' => 'Test invoice',
        ]);

        $this->call(EquipoSeeder::class);
        $this->call(TrasladoSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
