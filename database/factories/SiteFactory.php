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
    private static $avatarIndex = 0;
    public function definition(): array
    {


        $avatars = [
            'logos/avatar1.png',
            'logos/avatar2.png',
            'logos/avatar3.png',
            'logos/avatar4.png',
            'logos/avatar5.png',
            'logos/avatar6.png',
            'logos/avatar7.png',
            'logos/avatar8.png',
            'logos/avatar9.png',
            'logos/avatar10.png',
            'logos/avatar11.png',
            'logos/avatar12.png',
            'logos/avatar13.png',
            'logos/avatar14.png',
            'logos/avatar15.png',
            'logos/avatar16.png',
            'logos/avatar17.png',
            'logos/avatar18.png',
            'logos/avatar19.png',
            'logos/avatar20.png',
            'logos/avatar21.png',
        ];

        if (self::$avatarIndex >= count($avatars)) {
            self::$avatarIndex = 0;
        }

        $avatar = $avatars[self::$avatarIndex];
        self::$avatarIndex++;

        $typeIds = Type::whereIn('name', TypeName::toArray())->pluck('id')->toArray();


        return [
            'name' => fake()->company(),
            'avatar' => $avatar,
            'category' => fake()->company(),
            'currency' => $this->faker->randomElement(CurrencyType::toArray()),
            'payment_expiration_time' => $this->faker->numberBetween(1, 1440),
            'required_fields' => [],
            'type_id' => $this->faker->randomElement($typeIds),
        ];
    }
}
