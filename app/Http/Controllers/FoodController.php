<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    // Nampilin daftar makanan di halaman admin, 10 data per halaman, yang terbaru di atas
    public function index()
    {
        $foods = Food::latest()->paginate(10);
        return view('admin.foods.index', compact('foods'));
    }

    // Nampilin halaman form buat nambah makanan baru
    public function create()
    {
        return view('admin.foods.create');
    }

    // Proses simpan makanan baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form dulu sebelum disimpan
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman,Cemilan',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // gambar boleh kosong
        ]);

        // Kalau ada gambar yang diupload, simpan ke folder "foods" di storage public
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Simpan data makanan baru ke database
        Food::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        // Balik ke halaman daftar makanan + pesan sukses
        // NOTE: nama route-nya kayaknya harus "admin.foods.index", bukan "foods.index"
        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil ditambahkan!');
    }

    // Nampilin form edit, otomatis ke-load data food-nya lewat route model binding
    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    // Proses update data makanan yang udah ada
    public function update(Request $request, Food $food)
    {
        // Validasi input, sama kayak pas nambah data baru
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman,Cemilan',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Defaultnya gambar lama tetap dipakai
        $imagePath = $food->image;

        // Tapi kalau user upload gambar baru...
        if ($request->hasFile('image')) {
            // Hapus dulu gambar lama dari storage biar nggak numpuk file nggak kepake
            if ($food->image && Storage::disk('public')->exists($food->image)) {
                Storage::disk('public')->delete($food->image);
            }
            // Baru simpan gambar barunya
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Update data makanan di database
        $food->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        // Balik ke halaman daftar makanan + pesan sukses
        // NOTE: sama kayak di atas, cek lagi nama route-nya
        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil diperbarui!');
    }

    // Proses hapus data makanan
    public function destroy(Food $food)
    {
        // Hapus gambarnya dulu dari storage (kalau ada), biar nggak jadi sampah file
        if ($food->image && Storage::disk('public')->exists($food->image)) {
            Storage::disk('public')->delete($food->image);
        }
        // Baru hapus data makanannya dari database
        $food->delete();

        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil dihapus!');
    }
}