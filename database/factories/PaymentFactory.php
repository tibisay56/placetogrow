<?php

namespace Database\Factories;

use App\Constants\CurrencyType;
use App\Constants\PaymentGateway;
use App\Constants\PaymentStatus;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'reference' => Str::random(),
            'amount' => $this->faker->numberBetween(1000, 10000),
            'currency' => CurrencyType::USD->name,
            'gateway' => PaymentGateway::PLACETOPAY->value,
            'status' => $this->faker->randomElement(PaymentStatus::toArray()),
            'site_id' => Site::factory(),
            'user_id' => User::factory(),
            'payer_name' => $this->faker->name(),
            'required_fields' => [],
        ];
    }
}
