<?php

namespace App\Http\Controllers;
//buat import gitu manggil sesuai apa yg di import yh
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
//buat ngasih akses langsung ke database, tanpa harus lewat Model/Eloquent.
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Nampilin halaman utama customer, isinya daftar semua menu makanan
    public function index()
    {
        $foods = Food::all();
        return view('customer.index', compact('foods'));
    }

    // Proses simpan pesanan customer
    public function store(Request $request)
    {
        // Validasi input dulu: nama & nomor meja wajib diisi,
        // items harus array (jumlah tiap menu), boleh kosong per item tapi nggak boleh minus
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number'  => 'required|integer|min:1',
            'items'          => 'required|array',
            'items.*'        => 'nullable|integer|min:0',
        ]);

        // Ambil cuma item yang qty-nya lebih dari 0 (yang beneran dipesan)
        $orderedItems = array_filter($request->items, fn ($qty) => $qty > 0);

        // Kalau ternyata nggak ada satupun menu yang dipilih, tolak dan kasih pesan error
        if (empty($orderedItems)) {
            return back()->with('error', 'Pilih minimal satu menu makanan!');
        }

        // Mulai transaksi database, biar aman kalau di tengah jalan ada yang gagal
        // (semua proses insert dibatalkan bareng, nggak ada data setengah-setengah)
        DB::beginTransaction();
        try {
            // Bikin data pesanan (order) dulu, total_price sementara diisi 0
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number'  => $request->table_number,
                'total_price'   => 0,
                'status'        => 'pending',
            ]);

            $totalPrice = 0;

            // Looping tiap menu yang dipesan buat disimpan detailnya
            foreach ($orderedItems as $foodId => $quantity) {
                // Ambil data makanan berdasarkan id-nya, kalau nggak ketemu otomatis error 404
                $food = Food::findOrFail($foodId);

                // Hitung subtotal = harga satuan x jumlah yang dipesan
                $subtotal = $food->price * $quantity;

                // Tambahin ke total keseluruhan pesanan
                $totalPrice += $subtotal;

                // Simpan detail pesanan (menu apa, berapa banyak, harga berapa)
                OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id'  => $food->id,
                    'quantity' => $quantity,
                    'price'    => $food->price,  // harga satuan saat itu (disimpan biar histori harga aman)
                    'subtotal' => $subtotal,
                ]);
            }

            // Update total_price di data order sesuai hasil perhitungan tadi
            $order->update(['total_price' => $totalPrice]);

            // Semua proses berhasil, simpan permanen ke database
            DB::commit();

            // Balik ke halaman utama + pesan sukses berisi nomor meja
            return redirect()->route('customer.index')->with('success', 'Pesanan berhasil dibuat! Nomor Meja: ' . $order->table_number);
        } catch (\Exception $e) {
            // Kalau ada error di tengah proses, batalin semua perubahan (rollback)
            DB::rollBack();

            // Balik ke halaman sebelumnya + tampilin pesan errornya
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // Nampilin halaman dashboard admin, isinya daftar semua pesanan
    // beserta detail menu & data makanannya (pakai eager loading biar query-nya efisien)
    public function adminDashboard()
    {
        $orders = Order::with('orderDetails.food')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    // Proses update status pesanan (misal dari "pending" jadi "diproses" atau "selesai")
    public function updateStatus(Request $request, $id)
    {
        // Pastiin status yang dikirim ada isinya
        $request->validate(['status' => 'required|string']);

        // Cari pesanan berdasarkan id, kalau nggak ketemu otomatis error 404
        $order = Order::findOrFail($id);

        // Update status pesanannya
        $order->update(['status' => $request->status]);

        // Balik ke halaman sebelumnya + pesan sukses
        return back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui!');
    }
}