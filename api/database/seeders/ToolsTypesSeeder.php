<?php

namespace Database\Seeders;

use App\Models\ToolsTypes;
use Illuminate\Database\Seeder;

class ToolsTypesSeeder extends Seeder
{
    public function run(): void
    {
        ToolsTypes::factory(10)->create();
    }
}
