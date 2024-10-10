<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProveedorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proveedor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'calle' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'numero_int' => $this->faker->buildingNumber,
            'colonia' => $this->faker->sentence(3),
            'cp' => $this->faker->postcode,
            'ciudad' => $this->faker->city,
            'estado' => $this->faker->state,
            'rfc' => Str::random(12),
            'telefono' => $this->faker->e164PhoneNumber,
            'correo' => $this->faker->unique()->safeEmail(),
            'comentarios' => $this->faker->sentence(5)
        ];
    }
}
