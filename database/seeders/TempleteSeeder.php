<?php

namespace Database\Seeders;

use App\Models\Templete;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('templetes')->delete();

        Templete::create([

            'num_templete' => 1,
            'file_name' => 'templete1.JPG'

        ]);
        Templete::create([

            'num_templete' => 2,
            'file_name' => 'templete2.JPG'
        ]);
        Templete::create([

            'num_templete' => 3,
            'file_name' => ''
        ]);
    }
}
