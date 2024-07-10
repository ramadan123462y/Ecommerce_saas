<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('plans')->delete();


        Plan::create([

            'duration' => 'month',
            // 'templete_id' => 1
        ]);
        Plan::create([

            'duration' => 'month',
            // 'templete_id' => 2
        ]);
        Plan::create([

            'duration' => 'month',
            // 'templete_id' => 3
        ]);
    }
}
