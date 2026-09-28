<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Food extends Model
{
    use HasFactory; // Biar bisa dipakai buat generate data dummy lewat factory/seeder

    protected $table = 'food'; // Nama tabel di database bukan "foods" (default), tapi "food"

    // Semua kolom boleh diisi lewat mass assignment (Food::create([...])), kecuali "id"
    protected $guarded = ['id'];
}