<?php

namespace Database\Factories;

use App\Constants\BillingFrequency;
use App\Constants\CurrencyType;
use App\Constants\SubscriptionStatus;
use App\Models\Plan;
use App\Models\PlanType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {

        $planTypeIds = PlanType::pluck('id')->toArray();

        return [
            'name' => $this->faker->randomElement(['Basic', 'Medium', 'Premium']),
            'description' => $this->faker->text(30),
            'amount' => $this->faker->numberBetween(100, 10000),
            'currency' => $this->faker->randomElement(CurrencyType::toArray()),
            'status' => $this->faker->randomElement(SubscriptionStatus::toArray()),
            'subscription_expiration' => $this->faker->numberBetween(1, 365),
            'billing_frequency' => $this->faker->randomElement(BillingFrequency::toArray()),
            'plan_type_id' => $this->faker->randomElement($planTypeIds),
            'site_id' => 3,
            'user_id' => $this->faker->optional()->randomElement([null, $this->faker->numberBetween(1, 10)]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
