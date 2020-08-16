<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'profile_image' => 'profileImage.png',
            'name' => 'arif',
            'email' => 'arifaov@outlook.com',
            'password' => Hash::make('arif6376'),
            'status' => 9,
            'slug'=>'arif-6534'
        ]);
    }
}
