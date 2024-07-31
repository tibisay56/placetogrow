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
        $types = array_map(function (string $name) {

            return ['name' => $name, 'created_at' => now(), 'updated_at' => now(),];
        }, TypeName::toArray());

        Type::insert($types);
    }
}
