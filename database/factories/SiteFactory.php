<?php

namespace Database\Factories;

use App\Constants\CurrencyType;
use App\Constants\TypeName;
use App\Models\Site;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {

        $typeIds = Type::whereIn('name', TypeName::toArray())->pluck('id')->toArray();

        return [
            'name' => fake()->company(),
            'category' => fake()->company(),
            'currency' => $this->faker->randomElement(CurrencyType::toArray()),
            'payment_expiration_time' => $this->faker->numberBetween(1, 1440),
            'required_fields' => [],
            'type_id' => $this->faker->randomElement($typeIds),
        ];
    }

    public function subscriptionType(): self
    {
        return $this->state(fn () => ['type' => TypeName::SUBSCRIPTIONS->value]);
    }
}
