## Deskripsi Proyek Geschaft
Geschaft adalah sebuah aplikasi sederhana untuk pemesanan barang, yang dibangun menggunakan framework Laravel 10. Aplikasi ini dirancang untuk memudahkan pengguna dalam melakukan transaksi pembelian barang dengan sistem yang efisien dan terorganisir.

### Persyaratan
Pastikan komputer Anda telah terinstal dengan:
-   PHP 8.1 atau versi yang lebih tinggi
-   Composer
-   MySQL atau database lain yang kompatibel

### Instalasi
1. **Clone Repositori**
    Clone repositori Geschaft dari GitHub

2. **Masuk ke Direktori Proyek**
    Masuk ke direktori proyek Geschaft

3. **Instal Dependensi dengan Composer**
    ```bash
    composer install
    ```

4. **Salin Berkas .env**
    Salin berkas `.env.example` dan simpan sebagai `.env`.

5. **Generate APP_KEY**
    ```bash
    php artisan key:generate
    ```

6. **Buat Database**
    Buatlah database kosong di MySQL untuk aplikasi Geschaft.

7. **Konfigurasi Database**
    Konfigurasikan koneksi database di berkas `.env`. Atur `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan pengaturan database Anda.

8. **Jalankan Migrasi**
    Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:
    ```bash
    php artisan migrate:fresh --seed
    ```

9. **Jalankan Server**
    Jalankan server pengembangan dengan perintah:
    ```bash
    php artisan serve
    ```

10. **Akses Aplikasi**
    Buka browser dan akses aplikasi Geschaft melalui URL berikut: [http://localhost:8000](http://localhost:8000)

### Kredensial Login
Gunakan kredensial berikut untuk masuk ke aplikasi Geschaft:
Email: admin@dev.test
Password: pwd
