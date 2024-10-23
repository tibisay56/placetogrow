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
            'avatar' => $this->generateRandomImage(),
        ];
    }

    /**
     * Generate a random image filename.
     *
     * @return string
     */
    protected function generateRandomImage()
    {
        $imageNames = [
            'default_avatar.png',
            'image_1.png',
            'image_2.png',
        ];

        $imageName = $this->faker->randomElement($imageNames);

        return $imageName;
    }

    public function subscriptionType(): self
    {
        return $this->state(fn () => ['type' => TypeName::SUBSCRIPTIONS->value]);
    }
}
