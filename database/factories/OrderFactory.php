<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => $this->uniqueOrderNumber(),
            'total_amount' => $this->faker->numberBetween(10000, 100000),
            'notes' => $this->faker->sentence(5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function uniqueOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD' . rand(100000, 999999);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
