<?php

use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('providers')->insert([
            [
                'name' => "Provider1",
                'endpoint' => "https://www.mediaclick.com.tr/api/5d47f235330000623fa3ebf7.json",
                'parameters' => "level,estimated_duration,{key}",
                'is_active' => 1,
            ],
            [
                'name' => "Provider2",
                'endpoint' => "https://www.mediaclick.com.tr/api/5d47f24c330000623fa3ebfa.json",
                'parameters' => "zorluk,sure,id",
                'is_active' => 1,
            ],
        ]);
    }
}
