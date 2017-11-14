<?php

use Illuminate\Database\Seeder;
use Ahelos\Printer;

class PrintersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Printer::create([
            'user_id' => 1,
            'name' => 'Canon Pixma MP510'
        ]);

        Printer::create([
            'user_id' => 1,
            'name' => 'Lexmark X950'
        ]);

        Printer::create([
            'user_id' => 1,
            'name' => 'HP 505'
        ]);
    }
}
