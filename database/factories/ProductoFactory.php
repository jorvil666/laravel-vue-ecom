<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nombre = $this->faker->text(25);
        $descripcion = $this->faker->text(200);
        $stock = $this->faker->numberBetween($min = 0, $max = 10);
        $precio = $this->faker->numberBetween($min = 5, $max = 50);
        $imagen = $this->faker->imageUrl($width = 140, $height = 300);
        $rating = $this->faker->numberBetween($min = 1, $max = 5);

        return [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'stock' => $stock,
            'precio' => $precio,
            'imagen' => $imagen,
            'rating' => $rating,
            'fidelizacion' => $this->faker->numberBetween($min = 0, $max = 1),
            'estado' => $this->faker->numberBetween($min = 0, $max = 1),
        ];
    }
}
