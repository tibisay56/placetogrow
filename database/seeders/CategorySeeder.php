<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Basic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Invoicing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Subscribe', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
