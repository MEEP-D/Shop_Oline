<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id(); // Tạo cột id với AUTO_INCREMENT
        $table->string('name'); // Tạo cột name với kiểu VARCHAR(255)
        $table->text('description')->nullable(); // Tạo cột description với kiểu TEXT và có thể NULL
        $table->decimal('price', 10, 2); // Tạo cột price với kiểu DECIMAL(10, 2)
        $table->unsignedBigInteger('category_id')->nullable(); // Đảm bảo sử dụng unsignedBigInteger cho khóa ngoại
        $table->timestamps(); // Tạo cột created_at và updated_at

        // Thêm khóa ngoại
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    });
}


    public function down()
    {
        Schema::dropIfExists('products');
    }
}
