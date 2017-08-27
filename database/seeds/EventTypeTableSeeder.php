<?php

use App\EventType;
use Illuminate\Database\Seeder;

class EventTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = collect([
            ['name' => 'Travel', 'class' => 'red', 'icon' => '', 'readonly' => true],
            ['name' => 'Leave', 'class' => 'orange', 'icon' => '', 'readonly' => true],
            ['name' => 'Birthdays', 'class' => 'yellow', 'icon' => '', 'readonly' => true],
            ['name' => 'Shopping', 'class' => 'olive', 'icon' => '', 'readonly' => true],
            ['name' => 'Public Holidays', 'class' => 'green', 'icon' => '', 'readonly' => true],
            ['name' => 'Cooking', 'class' => 'teal', 'icon' => '', 'readonly' => true],
            ['name' => 'Cleaning', 'class' => 'blue', 'icon' => '', 'readonly' => true],
        ])->toArray();
        EventType::insert($types);
    }
}