<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deals')->insert([
            'enable_disable'=>0,
        ]);
    }
}
