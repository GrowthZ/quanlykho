<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'quantity', 'purchase_price','price', 'weight', 'origin','category_id','status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)
            ->withPivot('quantity', 'purchase_price', 'import_date')
            ->withTimestamps();
    }
}
