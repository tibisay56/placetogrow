<?php

namespace Database\Factories;

use App\Constants\DocumentTypes;
use App\Constants\SubscriptionStatus;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $site = Site::where('type_id', 3)->inRandomOrder()->first();

        if (! $site) {
            $site = Site::factory()->create([
                'type_id' => 3,
            ]);
        }

        return [
            'user_id' => User::factory(),
            'plan_id' => Plan::factory(),
            'site_id' => $site->id,
            'status' => $this->faker->randomElement(SubscriptionStatus::toArray()),
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->word(),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'document_type' => $this->faker->randomElement(DocumentTypes::toArray()),
        ];
    }
}
