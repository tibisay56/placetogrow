<?php

namespace Database\Factories;

use App\Constants\DocumentTypes;
use App\Constants\SubscriptionStatus;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {

        return [
            'user_id' => User::factory(),
            'plan_id' => Plan::factory(),
            'site_id' => Site::factory()->create(['type_id' => 3])->id,
            'status' => $this->faker->randomElement(SubscriptionStatus::toArray()),
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->word(),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'document_type' => $this->faker->randomElement(DocumentTypes::toArray()),
            'token' => Str::random(70),
            'sub_token' => Str::random(50),
            'next_payment_at' => now()->toDateString(),
        ];
    }

    public function statusApproved(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => SubscriptionStatus::APPROVED,
            ];
        });
    }
}
