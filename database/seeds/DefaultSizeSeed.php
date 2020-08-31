<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultSizeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('default_sizes')->insert([
            'size'=>'XXS',
            'slug'=>'xxs',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'XS',
            'slug'=>'xs',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'S',
            'slug'=>'s',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'M',
            'slug'=>'m',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'L',
            'slug'=>'l',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'XL',
            'slug'=>'xl',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'XXL',
            'slug'=>'xxl',
        ]);
        DB::table('default_sizes')->insert([
            'size'=>'XXXL',
            'slug'=>'xxxl',
        ]);
    }
}
