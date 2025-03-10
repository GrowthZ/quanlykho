<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouses'; // Bảng warehouses trong DB
    protected $fillable = ['name', 'location']; // Các cột được phép điền

    // Quan hệ với bảng product_warehouse
    public function productWarehouses()
    {
        return $this->hasMany(ProductWarehouse::class, 'warehouse_id');
    }

    // 🔹 Đếm số sản phẩm có trong kho (quantity > 0)
    public function countProducts()
    {
        return $this->productWarehouses()->where('quantity', '>', 0)->count();
    }

    // 🔹 Đếm số loại sản phẩm khác nhau trong kho
    public function countDistinctProducts()
    {
        return $this->productWarehouses()
            ->where('quantity', '>', 0)
            ->distinct('product_id')
            ->count('product_id');
    }

    public function totalQuantity()
    {
        return $this->productWarehouses()->sum('quantity');
    }

    public function totalValue()
    {
        return $this->productWarehouses()->sum(DB::raw('quantity * purchase_price'));
    }
}
