<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total', 'status', 'payment_method'
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id'); // Đảm bảo sử dụng đúng tên cột
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class); // Một đơn hàng có nhiều thanh toán
    }
}
