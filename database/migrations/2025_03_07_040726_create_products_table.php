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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Tự động tạo khóa chính với AUTO_INCREMENT
            $table->string('code')->unique(); // Mã sản phẩm không được trùng
            $table->string('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('purchase_price')->nullable();
            $table->integer('price')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('origin')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
