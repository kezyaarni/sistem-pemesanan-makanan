<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory; // Biar bisa dipakai buat bikin data dummy lewat factory/seeder

    // Semua kolom boleh diisi lewat mass assignment (Order::create([...])), kecuali "id"
    protected $guarded = ['id'];

    // Relasi: 1 pesanan (order) bisa punya banyak detail item (menu yang dipesan)
    // Dipakai misalnya buat: $order->orderDetails
    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}