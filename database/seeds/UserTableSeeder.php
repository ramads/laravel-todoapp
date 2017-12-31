<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'name' => 'rama',
                'email' => 'rama@gmail.com',
                'password' => bcrypt('ramads')
            ],
            [
                'name' => 'ditia',
                'email' => 'ditia@gmail.com',
                'password' => bcrypt('ramads')
            ]
        ]);
    }
}
