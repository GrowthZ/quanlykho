<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('warehouses')->insert([
            ['name' => 'Kho DH', 'location' => 'Hanoi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kho Tala', 'location' => 'Ho Chi Minh City', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kho Á Âu', 'location' => 'Ho Chi Minh City', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
