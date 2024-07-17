<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{

    public function run(): void
    {
        Site::factory()->count(10)->create();
    }
}
