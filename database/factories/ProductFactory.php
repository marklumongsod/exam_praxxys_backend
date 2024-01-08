<?php

namespace Database\Factories;


use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->sentence(2),
            'Category' => $this->faker->word,
            'Description' => $this->faker->paragraph,
            'DateTime' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'images' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()])
        ];
    }
}
