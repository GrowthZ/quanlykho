<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductWarehouseSeeder extends Seeder
{
    public function run()
    {
        // Lấy danh sách ID của products và warehouses từ database
        $productIds = DB::table('products')->pluck('id')->toArray();
        $warehouseIds = DB::table('warehouses')->pluck('id')->toArray();

        // Kiểm tra nếu không có dữ liệu thì không chạy
        if (empty($productIds) || empty($warehouseIds)) {
            $this->command->info('Không có dữ liệu trong bảng products hoặc warehouses!');
            return;
        }

        $data = [];

        foreach ($productIds as $productId) {
            // Gán sản phẩm này cho tất cả các kho
            foreach ($warehouseIds as $warehouseId) {
                $data[] = [
                    'product_id'   => $productId,
                    'warehouse_id' => $warehouseId,
                    'quantity'     => rand(0, 500), // Số lượng ngẫu nhiên từ 0 - 500
                    'purchase_price' => rand(100, 1000) * 1000, // Giá nhập ngẫu nhiên từ 100k - 1000k
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }
        }

        // Chèn dữ liệu vào bảng product_warehouse
        DB::table('product_warehouse')->insert($data);

        $this->command->info('Seeder product_warehouse đã chạy thành công!');
    }
}
