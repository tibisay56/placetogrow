<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'retry_interval' => $this->faker->numberBetween(1, 10),
            'max_retries' => $this->faker->numberBetween(1, 5),
        ];
    }
}
