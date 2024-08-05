<?php

namespace Database\Factories;

use App\Constants\CurrencyType;
use App\Models\Site;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    protected $model = Site::class;
    private $avatars = [
        '8cwvsj4UhkntwRaL1pwCFiuazNJYefWRvcfl1k3f.png',
        'oS5ImnUkh3y1LcPS70VXZ4Ss2JIndPqhAj4Ikp5P.png',
        '6F7y30mRidurhaxTWh2ire4pmas5we1KHcdfBcbT.png',
        'ABqTc3VPhJGXwJCuDsjaWiij6OLHmJ6BzJLbtAEJ.png',
        'dkaxn49vmJXKETLcQe75Eh9moLrgb8LjhFdCwQcY.png',
        'g3U79D2hDolpTN59bpAZ93bVeJrKlZnw5MPtxCyH.png',
        'gTprNJGOptpTwPrTBDhEXBMokeCVUxO5QlmaTpM2.png',
        'N1G5VX0T0edeoV5vSzK42QbsvsqLh1qdTRpUb55c.png',
        'rQmObsfLuf20OF0kuBxBVUbESvB2MmkMtYq4W3k6.png',
        'sBoru7enaggqixpzpTG2PL3hnQGY1e82EIEWsUK6.png',
        'MmUuiFNFREDlVhLdWd9kXPmgWjWwqkC7XTEAsNUK.png',
        'skVqdH0qTbapZ8jSc29hW1hfM81FLKiAFuSYP4N4.png'
    ];

    private $avatars = [
        '8cwvsj4UhkntwRaL1pwCFiuazNJYefWRvcfl1k3f.png',
        'oS5ImnUkh3y1LcPS70VXZ4Ss2JIndPqhAj4Ikp5P.png',
        '6F7y30mRidurhaxTWh2ire4pmas5we1KHcdfBcbT.png',
        'ABqTc3VPhJGXwJCuDsjaWiij6OLHmJ6BzJLbtAEJ.png',
        'dkaxn49vmJXKETLcQe75Eh9moLrgb8LjhFdCwQcY.png',
        'g3U79D2hDolpTN59bpAZ93bVeJrKlZnw5MPtxCyH.png',
        'gTprNJGOptpTwPrTBDhEXBMokeCVUxO5QlmaTpM2.png',
        'N1G5VX0T0edeoV5vSzK42QbsvsqLh1qdTRpUb55c.png',
        'rQmObsfLuf20OF0kuBxBVUbESvB2MmkMtYq4W3k6.png',
        'sBoru7enaggqixpzpTG2PL3hnQGY1e82EIEWsUK6.png',
        'MmUuiFNFREDlVhLdWd9kXPmgWjWwqkC7XTEAsNUK.png',
        'skVqdH0qTbapZ8jSc29hW1hfM81FLKiAFuSYP4N4.png',
    ];

    public function definition(): array
    {

        $randomAvatar = $this->faker->unique()->randomElement($this->avatars);

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
