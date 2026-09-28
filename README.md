<div align="center">

  # 🍽️ Restaurant Food Ordering System

  **Sistem Pemesanan Makanan Restoran Berbasis Web Menggunakan Framework Laravel**

  [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

</div>

---

## 📌 Tentang Proyek

Aplikasi **Sistem Pemesanan Makanan Restoran** dirancang untuk mempermudah proses pemesanan makanan secara mandiri oleh pelanggan di meja restoran. Pelanggan dapat melihat katalog menu, memfilter kategori, dan langsung melakukan pemesanan tanpa perlu menunggu pelayan. 

Setiap pesanan yang terkirim akan diproses oleh *backend* Laravel dan langsung memunculkan notifikasi (*Flash Message*) secara instan.

---

## ✨ Fitur Utama

### 👨‍🍳 Sisi Pelanggan (Customer Page)
* **Katalog Menu Interaktif**: Menampilkan daftar makanan, minuman, dan cemilan beserta gambar, deskripsi, dan harga.
* **Filter Kategori Instant**: Memfilter daftar menu berdasarkan kategori (Makanan, Minuman, Cemilan) menggunakan JavaScript tanpa perlu *reload* halaman.
* **Pemesanan Ringkas**: Pelanggan hanya perlu menginput **Nama Lengkap** dan **Nomor Meja**, serta menentukan porsi item.
* **Notifikasi Instan**: Menampilkan *Flash Message* (`Success` / `Error`) secara langsung setelah tombol **Pesan Sekarang** diklik.

### 🛡️ Sisi Admin (Admin Panel)
* **Dashboard Monitoring**: Melihat daftar transaksi pesanan masuk secara *real-time*.
* **Manajemen Menu (CRUD)**: Menambah, mengubah, atau menghapus menu makanan beserta gambar hidangan.

---

## 📸 Tampilan Antarmuka (Screenshots)

| Halaman Menu Utama | Notifikasi Pesanan Berhasil |
| :---: | :---: |
| ![Preview Menu](https://via.placeholder.com/600x350.png?text=Preview+Menu+Restoran) | ![Preview Flash Message](https://via.placeholder.com/600x350.png?text=Preview+Flash+Message) |

> *Ganti URL gambar di atas dengan screenshot asli aplikasi kamu jika sudah di-upload ke GitHub.*

---

## 🛠️ Teknologi & Tools

* **Framework**: [Laravel](https://laravel.com) (v10 / v11)
* **Language**: PHP >= 8.1
* **Database**: MySQL / MariaDB
* **Frontend**: Blade Templating, [Tailwind CSS](https://tailwindcss.com), JavaScript (Vanilla)
* **Icons & Styling**: Tailwind CDN

---

## 📂 Struktur Direktori Utama Proyek

```text
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── CustomerController.php   # Controller proses menu & checkout
│   └── Models/
│       ├── Food.php                      # Model data menu
│       ├── Order.php                     # Model data pesanan
│       └── OrderItem.php                 # Model rincian item pesanan
├── database/
│   └── migrations/                        # Skema tabel database
├── resources/
│   └── views/
│       └── menu.blade.php                 # Tampilan UI utama pelanggan
└── routes/
    └── web.php                            # Routing endpoint aplikasi


