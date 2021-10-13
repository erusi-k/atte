<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BreakTime;

class BreaKTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BreakTime::factory()->count(50)->create();
    }
}
