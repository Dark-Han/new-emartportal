<?php

namespace Database\Factories;

use App\Models\ToolsTypes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ToolsTypesFactory extends Factory
{
    protected $model = ToolsTypes::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
