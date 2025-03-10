<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->delete(); // Xóa toàn bộ dữ liệu mà không reset ID
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
        $products = [];
        
        for ($i = 0; $i < 100; $i++) {
            $code = strtoupper(Str::random(3)) . rand(1000, 9999);
            $description = Str::random(50);

            $products[] = [
                'code' => $code,
                'description' => $description,
                'quantity' => rand(0, 100),
                'weight' => rand(1, 10),
                'price' => rand(100, 1000) * 1000,
                'purchase_price' => rand(50, 500) * 1000,
                'origin' => 'China',
                'category_id' => rand(1, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
        
    }
}
