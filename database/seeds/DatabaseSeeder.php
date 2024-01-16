<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(ApplicationSettingsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(NavigationTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(PageTableSeeder::class);
    }
}
