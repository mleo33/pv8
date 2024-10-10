<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'direccion' => $this->faker->address,
            'correo' => $this->faker->unique()->safeEmail(),
            'limite_credito' => 25000,
            'dias_credito' => 30,
            'puntos' => 1000,
            'comentarios' => $this->faker->sentence(5)
        ];
    }
}
