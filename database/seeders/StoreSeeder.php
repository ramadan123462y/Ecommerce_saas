<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stores')->delete();
        Store::create([


            'title' => 'new',
            'sub_domain' => "new.localhost",

            'plan_id'=>1
        ]);
        Store::create([


            'title' => 'a',
            'sub_domain' => "a.localhost",
            'plan_id'=>1
        ]);
        Store::create([


            'title' => 'b',
            'sub_domain' => "b.localhost",
            'plan_id'=>1
        ]);
        Store::create([


            'title' => 'c',
            'sub_domain' => "c.localhost",
            'plan_id'=>1
        ]);
    }
}
