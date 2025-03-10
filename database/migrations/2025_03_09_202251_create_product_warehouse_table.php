<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Khóa ngoại tới products
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade'); // Khóa ngoại tới warehouses
            $table->integer('quantity'); // Số lượng nhập
            $table->integer('purchase_price'); // Giá nhập
            $table->integer('price')->nullable(); // Giá bán
            $table->date('import_date')->default(now()); // Ngày nhập kho
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouse');
    }
};
