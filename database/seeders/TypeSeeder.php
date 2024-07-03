<?php

namespace Database\Seeders;

use App\Constants\TypeName;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TypeName::cases() as $type) {
            Type::create(['name' => $type->value]);
        }
    }
}
