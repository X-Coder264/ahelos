<?php

use Illuminate\Database\Seeder;
use Ahelos\PrinterInk;

class InksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrinterInk::create([
            'printer_id' => 1,
            'name' => 'MP 52'
        ]);

        PrinterInk::create([
            'printer_id' => 1,
            'name' => 'MX 60'
        ]);

        PrinterInk::create([
            'printer_id' => 2,
            'name' => 'RX 20'
        ]);
    }
}
