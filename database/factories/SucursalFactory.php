<?php

namespace Database\Factories;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;

class SucursalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sucursal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->catchPhrase,
            'direccion' => $this->faker->address,
            'telefono' =>$this->faker->e164PhoneNumber,
            'comentarios' => $this->faker->sentence(5)

        ];
    }
}
