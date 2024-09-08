<?php

namespace Database\Factories;

use App\Models\PlanType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanTypeFactory extends Factory
{
    protected $model = PlanType::class;

    public function definition(): array
    {

        return [
            'name' => $this->faker->randomElement(['basic', 'medium', 'premium']),
        ];
    }
}
