<?php

namespace Database\Seeders;

use App\Models\Industries;
use Illuminate\Database\Seeder;

class IndustriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Industries::factory(10)->create();
    }
}
