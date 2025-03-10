<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWarehouse extends Model
{
    use HasFactory;

    protected $table = 'product_warehouse'; // Bảng liên kết giữa sản phẩm và kho
    protected $fillable = ['product_id', 'warehouse_id', 'quantity', 'purchase_price'];

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với Warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
