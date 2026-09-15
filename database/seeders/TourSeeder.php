<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tour::create(['name' => 'Ha Long Bay Cruise', 'slug' => 'ha-long-bay-cruise']);
        Tour::create(['name' => 'Sapa Trekking', 'slug' => 'sapa-trekking']);
        Tour::create(['name' => 'Mekong Delta Tour', 'slug' => 'mekong-delta-tour']);
    }
}
