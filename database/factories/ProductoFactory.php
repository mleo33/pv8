<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        $marcas = ['LOREAL', 'MAYBELLINE', 'GARNIER', 'ESSIE', 'NYX'];
        return [
			'codigo' => $this->faker->unique()->numberBetween(100000, 999999),
			'descripcion' => $this->faker->name,
            'marca' => $this->faker->randomElement($marcas),
			'unidad' => 'PZ',
			'clave_producto_id' => 1,
			'clave_unidad_id' => 1,
        ];
    }
}
