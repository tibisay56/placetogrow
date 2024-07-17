<?php

namespace Database\Factories;

use App\Constants\CurrencyType;
use App\Models\Site;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'avatar' => 'default_avatar.jpg',
            'category' => fake()->company(),
            'currency' => $this->faker->randomElement(CurrencyType::toArray()),
            'payment_expiration_time' => $this->faker->numberBetween(1, 1440),
            'type_id' => Type::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }

}
