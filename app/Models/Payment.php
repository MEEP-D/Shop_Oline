<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Các cột có thể được điền thông qua mass assignment
    protected $fillable = ['order_id', 'amount', 'payment_date', 'payment_method'];

    // Mối quan hệ với bảng Orders
    public function order()
    {
        return $this->belongsTo(Orders::class); // Liên kết với model Order (số ít)
    }
}
