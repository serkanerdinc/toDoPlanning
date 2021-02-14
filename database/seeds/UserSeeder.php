<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            [
                'name' => "Dev1",
                'level' => 1,
            ],
            [
                'name' => "Dev2",
                'level' => 2,
            ],
            [
                'name' => "Dev3",
                'level' => 3,
            ],
            [
                'name' => "Dev4",
                'level' => 4,
            ],
            [
                'name' => "Dev5",
                'level' => 5,
            ]
        ]);
    }
}
