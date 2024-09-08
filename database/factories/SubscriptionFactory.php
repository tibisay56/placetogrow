<?php

namespace Database\Factories;

use App\Constants\DocumentTypes;
use App\Constants\SubscriptionStatus;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan_id' => Plan::factory(),
            'status' => $this->faker->randomElement(SubscriptionStatus::toArray()),
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->word(),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'document_type' => $this->faker->randomElement(DocumentTypes::toArray()),
        ];
    }
}
