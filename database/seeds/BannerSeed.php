<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banners')->insert(
            [
                'id' => 1,
                'image'=>'1.jpg',
                'title'=>'Default',
                'link'=>'default',
                'slug' => 'default-1',
                'switch' => 1,
            ]);
        DB::table('banners')->insert([
            'id' => 2,
            'image'=>'2.jpg',
            'title'=>'Default',
            'link'=>'default',
            'slug' => 'default-2',
            'switch' => 1,
        ]);
        DB::table('banners')->insert([
            'id' => 3,
            'image'=>'3.jpg',
            'title'=>'Default',
            'link'=>'default',
            'slug' => 'default-3',
            'switch' => 1,
        ]);
        DB::table('banners')->insert([
            'id' => 4,
            'image'=>'4.jpg',
            'title'=>'Default',
            'link'=>'default',
            'slug' => 'default-4',
            'switch' => 1,
        ]);
        DB::table('banners')->insert([
            'id' => 5,
            'image'=>'5.jpg',
            'title'=>'Default',
            'link'=>'default',
            'slug' => 'default-5',
            'switch' => 1,
        ]);

    }
}
