<?php

namespace Database\Factories;

use App\Constants\TypeName;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(TypeName::toArray()),
        ];
    }
}
