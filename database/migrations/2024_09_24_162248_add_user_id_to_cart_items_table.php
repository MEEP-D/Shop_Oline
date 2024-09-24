<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCartItemsTable extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Thêm cột user_id
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Xóa foreign key nếu cần
            $table->dropColumn('user_id'); // Xóa cột user_id
        });
    }
}
