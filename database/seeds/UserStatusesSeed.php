<?php

use Illuminate\Database\Seeder;

class UserStatusesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
            'id' => 1,
            'status' => 9,
            'status_name' => 'Super Admin',
        ]);

        DB::table('user_statuses')->insert([
            'id' => 2,
            'status' => 8,
            'status_name' => 'Admin',
        ]);

        DB::table('user_statuses')->insert([
            'id' => 3,
            'status' => 7,
            'status_name' => 'Staff',
        ]);

        DB::table('user_statuses')->insert([
            'id' => 4,
            'status' => 1,
            'status_name' => 'Editor',
        ]);

        DB::table('user_statuses')->insert([
            'id' => 5,
            'status' => 0,
            'status_name' => 'User',
        ]);
    }
}
