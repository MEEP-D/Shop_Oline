<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Liên kết với bảng orders
            $table->decimal('amount', 10, 2); // Số tiền thanh toán
            $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP')); // Ngày thanh toán
            $table->enum('payment_method', ['COD', 'online'])->default('online'); // Phương thức thanh toán
            $table->timestamps(); // Cột created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

