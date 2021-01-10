<?php

namespace Database\Seeders;

use Epigra\TrGeoZones\Database\Seeders\GeozoneCitiesTableSeeder;
use Epigra\TrGeoZones\Database\Seeders\GeozoneCityDistrictsTableSeeder;
use Epigra\TrGeoZones\Database\Seeders\GeozoneCountriesTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GeozoneCountriesTableSeeder::class);
        $this->call(GeozoneCitiesTableSeeder::class);
        $this->call(GeozoneCityDistrictsTableSeeder::class);
        // $this->call(ScenarioSeeder::class);
    }
}
