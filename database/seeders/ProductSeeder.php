<?php

namespace Database\Seeders;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'descripcion' => 'MARTILLO DEMOLEDOR',
            'categorias' => '[]',
            'codigo' => 'HM0870C',
            'marca' => 'MAKITA',
            'unidad' => 'PZ',
            'clave_producto_id' => 1,
            'clave_unidad_id' => 1,
        ]);

        Producto::create([
            'descripcion' => 'MOTOBOMBA HONDA DE 2 PULGADAS',
            'categorias' => '[]',
            'codigo' => '21152',
            'marca' => 'HONDA',
            'unidad' => 'PZ',
            'clave_producto_id' => 1,
            'clave_unidad_id' => 1,
        ]);

        Producto::create([
            'descripcion' => 'PISTOLA CALAFATEADORA',
            'categorias' => '[]',
            'codigo' => '22800',
            'marca' => 'TRUPER',
            'unidad' => 'PZ',
            'clave_producto_id' => 1,
            'clave_unidad_id' => 1,
        ]);

        Producto::create([
            'descripcion' => 'SET DE HERRAMIENTAS PARA MECANICA',
            'categorias' => '[]',
            'codigo' => '22984',
            'marca' => 'TRUPER',
            'unidad' => 'PZ',
            'clave_producto_id' => 1,
            'clave_unidad_id' => 1,
        ]);

        Producto::create([
            'descripcion' => 'ROTOMARTILLO ATORNILLADOR',
            'categorias' => '[]',
            'codigo' => 'DHP482SYE',
            'marca' => 'MAKITA',
            'unidad' => 'PZ',
            'clave_producto_id' => 1,
            'clave_unidad_id' => 1,
        ]);

        Producto::create([
            'descripcion' => 'SOLDADORA A GASOLINA',
            'categorias' => '[]',
            'codigo' => 'MYE3800',
            'marca' => 'HYUNDAI',
            'unidad' => 'PZ',
            'clave_producto_id' => 1,
            'clave_unidad_id' => 1,
        ]);

        $inventario = new Inventario();
        $inventario->producto_id = 1;
        $inventario->sucursal_id = 1;
        $inventario->minimo = 15;
        $inventario->existencia = 59;
        $inventario->costo = 80;
        $inventario->precio = 360;
        $inventario->activo = 1;
        $inventario->save();

        $inventario = new Inventario();
        $inventario->producto_id = 2;
        $inventario->sucursal_id = 1;
        $inventario->minimo = 20;
        $inventario->existencia = 88;
        $inventario->costo = 80;
        $inventario->precio = 380;
        $inventario->activo = 1;
        $inventario->save();
    }
}
