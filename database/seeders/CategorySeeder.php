<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Seed the database with fixed categories.
     *
     * @return void
     */
    public function run()
    {
      
        $categories = [
            ['title' => 'Transportation Vehicle', 'approval' => '1'],
            ['title' => 'Folklore Costumes, Equipments & Musical Instruments', 'approval' => '2'],
            ['title' => 'Event Venues', 'approval' => '3'],
            ['title' => 'Chairs & Tables', 'approval' => '1'],
        ];

       
        DB::table('categories')->insert($categories);
    }
}
