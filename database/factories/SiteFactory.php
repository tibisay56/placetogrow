<?php

namespace Database\Factories;

use App\Constants\CurrencyType;
use App\Models\Site;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        $avatars = [
            'storage/avatars/1DGx5fgftsWmKAthMaZ1VpaHFMn1Bg1qQaGqTyqs.jpg',
            'storage/avatars/tailwind.png',
            'storage/avatars/next.png',
            'storage/avatars/postger.png',
            'storage/avatars/ReactNative.png',
            'storage/avatars/express.png',
            'storage/avatars/html.png',
            'storage/avatars/framer.png',
            'storage/avatars/google.png',
        ];

        $randomAvatar = $this->faker->randomElement($avatars);

        return [
            'name' => fake()->company(),
            'avatar' => $randomAvatar,
            'category' => fake()->company(),
            'currency' => $this->faker->randomElement(CurrencyType::toArray()),
            'payment_expiration_time' => $this->faker->numberBetween(1, 1440),
            'type_id' => Type::factory(),
        ];
    }
}
