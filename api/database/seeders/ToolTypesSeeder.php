<?php

namespace Database\Seeders;

use App\Models\ToolTypes;
use Illuminate\Database\Seeder;

class ToolTypesSeeder extends Seeder
{
    public function run(): void
    {
        ToolTypes::factory(10)->create();
    }
}
