<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Masukin banyak data makanan sekaligus ke tabel "food"
        // Pakai DB::table() langsung (bukan Model), jadi lebih cepet buat insert banyak data
        DB::table('food')->insert([
            [
                'name' => 'Kwetiau Spesial',
                'category' => 'Makanan',
                'price' => 25000,
                'description'=> 'Kwetiau guring dengan tambahan sayur, telur, sosis, dan udang',
                'image' => null, // belum ada gambar, nanti bisa diupload lewat admin
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'name' => 'Udang Keju',
                'category' => 'Cemilan',
                'price' => 15000,
                'description'=> 'Adonan udang dengan keju lumer di dalamnya',
                'image' => null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'name' => 'Es Jeruk',
                'category' => 'Minuman',
                'price' => 10000,
                'description'=> 'Es jeruk peras asli yang menyegarkan',
                'image' => null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],[
                'name' => 'Es Teh',
                'category' => 'Minuman',
                'price' => 5000,
                'description'=> 'Es teh asli yang menyegarkan',
                'image' => null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'name' => 'Nasi Goreng Spesial',
                'category' => 'Makanan',
                'price' => 25000,
                'description'=> 'Nasi Goreng dengan tambahan sayur, telur, sosis',
                'image' => null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
        ]);
    }
}