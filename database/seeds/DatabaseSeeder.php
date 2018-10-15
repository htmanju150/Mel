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
        $this->call(BenefitsSeeder::class);
        $this->call(PolicyProvidersSeeder::class);
        $this->call(SpecializationsSeeder::class);
    }
}
