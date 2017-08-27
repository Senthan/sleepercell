<?php

use Illuminate\Database\Seeder;

class ActivityCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\ActivityCode::insert([
            [
            'name' => 'Cooking',
            'description' => 'Cooking'
            ],
            [
            'name' => 'Cleaning',
            'description' => 'Cleaning'
            ],
            [
            'name' => 'Shopping',
            'description' => 'Shopping'
            ],
            [
            'name' => 'Help',
            'description' => 'Help'
            ],
        ]);  
    }
}
