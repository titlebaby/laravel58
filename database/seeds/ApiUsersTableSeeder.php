<?php

use Illuminate\Database\Seeder;

class ApiUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\ApiUser', 10)->create([
            'password' => bcrypt('123456')
        ]);
    }
}
