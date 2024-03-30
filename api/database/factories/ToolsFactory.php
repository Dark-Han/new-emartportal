<?php

namespace Database\Factories;

use App\Models\Tools;
use App\Models\ToolsTypes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ToolsFactory extends Factory
{
    protected $model = Tools::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'tool_type_id' => ToolsTypes::factory(),
            'serial_number' => $this->faker->word(),
        ];
    }
}
