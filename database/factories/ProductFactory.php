<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    
    public function definition(): array
    {
        $randomPhotoId = $this->faker->numberBetween(1, 1000);

        return [
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(10000, 100000),
            'desc' => $this->faker->sentence(5),
            'foto' => "https://picsum.photos/id/{$randomPhotoId}/200/300",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
