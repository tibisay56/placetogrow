<?php

namespace Database\Seeders;

use App\Constants\PlanTypeName;
use App\Models\PlanType;
use Illuminate\Database\Seeder;

class PlanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanType::query()->delete();

        $planTypes = PlanTypeName::toArray();

        foreach ($planTypes as $name) {
            PlanType::create([
                'name' => $name,
            ]);
        }
    }
}
