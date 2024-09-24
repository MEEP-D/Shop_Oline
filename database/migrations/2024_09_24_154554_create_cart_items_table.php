<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Thêm foreign key đến bảng users
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Thêm foreign key đến bảng carts
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Thêm foreign key đến bảng products
            $table->integer('quantity')->default(1); // Số lượng sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
