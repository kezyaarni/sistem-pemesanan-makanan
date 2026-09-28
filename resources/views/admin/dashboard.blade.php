@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 1200px;">
    <!-- Header Judul & Tombol Kelola Master Makanan -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-2">
                <!-- Icon Kotak Judul Navy -->
                <div class="text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: #1e3a8a;">
                    <i class="bi bi-receipt-cutoff fs-5"></i>
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">Dashboard Rekap Pesanan</h3>
                    <p class="text-muted small mb-0">Kelola dan pantau status pesanan masuk dari pelanggan secara real-time.</p>
                </div>
            </div>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <!-- Tombol Kelola Master Makanan diarahkan pakai URL langsung -->
            <a href="{{ url('/admin/foods') }}" class="btn text-white fw-bold px-4 py-2 rounded-pill shadow-sm" style="background-color: #1e3a8a; transition: all 0.2s ease;">
                <i class="bi bi-box-seam me-2"></i> Kelola Master Makanan
            </a>
        </div>
    </div>

    <!-- Tabel Pesanan -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase fs-7" style="font-size: 11px; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3">Nama Pelanggan</th>
                            <th class="py-3">Meja</th>
                            <th class="py-3">Detail Pesanan</th>
                            <th class="py-3">Total Harga</th>
                            <th class="py-3 text-center">Status Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr style="transition: all 0.2s ease;">
                            <td class="py-3 px-4 text-muted fw-semibold">{{ $index + 1 }}</td>
                            <td class="py-3 fw-bold text-dark">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Inisial Nama (Navy) -->
                                    <div class="rounded-circle bg-light fw-bold d-flex align-items-center justify-content-center border" style="width: 32px; height: 32px; font-size: 13px; color: #1e3a8a; border-color: #cbd5e1 !important;">
                                        {{ substr($order->customer_name, 0, 1) }}
                                    </div>
                                    {{ $order->customer_name }}
                                </div>
                            </td>
                            <td class="py-3">
                                <!-- Badge Meja (Navy) -->
                                <span class="badge bg-light px-3 py-1.5 rounded-pill fw-semibold" style="color: #1e3a8a; border: 1px solid #93c5fd;">
                                    <i class="bi bi-shop me-1"></i> Meja {{ $order->table_number }}
                                </span>
                            </td>
                            <td class="py-3">
                                <ul class="list-unstyled mb-0 small text-secondary">
                                    @foreach($order->details as $detail)
                                        <li class="py-0.5">• {{ $detail->food->name ?? 'Menu Dihapus' }} <span class="fw-bold text-dark">({{ $detail->quantity }}x)</span></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 fw-bold text-dark">
                                <span class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 text-center">
                                <!-- Status Dropdown dengan Pastel Super Soft -->
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm rounded-pill px-3 py-1.5 fw-bold shadow-sm text-center border-0 status-dropdown" 
                                        style="font-size: 12px; cursor: pointer; width: 140px; margin: 0 auto; transition: all 0.2s ease;
                                        @if($order->status == 'Pending') background-color: #fef9c3; color: #854d0e; box-shadow: 0 2px 5px rgba(254, 249, 195, 0.4);
                                        @elseif($order->status == 'Diproses') background-color: #dbeafe; color: #1e3a8a; box-shadow: 0 2px 5px rgba(219, 234, 254, 0.4);
                                        @else background-color: #dcfce7; color: #166534; box-shadow: 0 2px 5px rgba(220, 252, 231, 0.4); @endif">
                                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }} style="background-color: #ffffff; color: #334155;">Pending</option>
                                        <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }} style="background-color: #ffffff; color: #334155;">Diproses</option>
                                        <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }} style="background-color: #ffffff; color: #334155;">Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-muted opacity-50 mb-2 d-block"></i>
                                    <p class="mb-0 fw-semibold text-secondary">Belum ada pesanan masuk saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .status-dropdown:hover {
        opacity: 0.92;
        transform: translateY(-1px);
    }
</style>
@endsection