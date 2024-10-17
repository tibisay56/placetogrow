<?php

namespace Database\Seeders;

use App\Constants\TypeName;
use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::query()->delete();

        $types = TypeName::toArray();

        foreach ($types as $name) {
            Type::create([
                'name' => $name,
            ]);
        }
    }
}
