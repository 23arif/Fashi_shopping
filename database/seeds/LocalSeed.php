<?php

use Illuminate\Database\Seeder;

class LocalSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locale')->insert([
            'id' => 1,
            'name' => 'English',
            'abbreviation' => 'en',
            'flag' => 'flag-1.jpg'
        ]);
        DB::table('locale')->insert([
            'id' => 2,
            'name' => 'Azerbaijan',
            'abbreviation' => 'aze',
            'flag' => 'flag-2.jpg'
        ]);
    }
}
