<?php

namespace Database\Seeders;

use App\Models\Import;
use Illuminate\Database\Seeder;

class ImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Import::factory()->count(10)->create();
    }
}
