<?php

namespace Database\Factories;

use App\Models\ToolTypes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ToolTypesFactory extends Factory
{
    protected $model = ToolTypes::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'selling_price' => $this->faker->numberBetween(10000, 200000),
            'rental_price' => $this->faker->numberBetween(1000, 10000),
            'discount_price' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
