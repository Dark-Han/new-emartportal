<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'iin' => $this->faker->word(),
            'full_name' => $this->faker->name(),
            'document_number' => $this->faker->word(),
            'document_given' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
