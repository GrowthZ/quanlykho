<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'code' => 1001,
                'name' => 'Electrical Components',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 1002,
                'name' => 'Automation & Control',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 1003,
                'name' => 'Switchgear',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 1004,
                'name' => 'Wiring Accessories',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
