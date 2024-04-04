<?php

namespace Database\Factories;

use App\Models\Shift;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShiftFactory extends Factory
{
    protected $model = Shift::class;

    public function definition(): array
    {
        return [
            'openingDate' => Carbon::now(),
            'closingDate' => Carbon::now(),

            'shop_id' => Shop::factory(),
        ];
    }
}
