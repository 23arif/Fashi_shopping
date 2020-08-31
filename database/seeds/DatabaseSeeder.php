<?php

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
         $this->call([
             UserSeed::class,
             SettingsSeed::class,
             DealsSeed::class,
             BannerSeed::class,
             LocalSeed::class,
             UserStatusesSeed::class,
             DefaultSizeSeed::class
         ]);
    }
}
