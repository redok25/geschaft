## Deskripsi

Geschaft adalah sebuah aplikasi sederhana untuk pemesanan barang, yang dibangun menggunakan framework Laravel 10.

### Persyaratan

Pastikan komputer Anda telah terinstal dengan:
-   PHP 8.1 atau versi yang lebih tinggi
-   Composer
-   MySQL atau database lain yang kompatibel

### Instalasi
1. **Clone Repositori**

   Clone repositori Geschaft dari GitHub

3. **Masuk ke Direktori Proyek**

   Masuk ke direktori proyek Geschaft

5. **Instal Dependensi dengan Composer**

   ```bash
    composer install
    ```

7. **Salin Berkas .env**

   Salin berkas `.env.example` dan simpan sebagai `.env`.

9. **Generate APP_KEY**

   ```bash
    php artisan key:generate
    ```

11. **Buat Database**

    Buatlah database kosong di MySQL untuk aplikasi Geschaft.

13. **Konfigurasi Database**

    Konfigurasikan koneksi database di berkas `.env`. Atur `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan pengaturan database Anda.

15. **Jalankan Migrasi**

    Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:
    ```bash
    php artisan migrate:fresh --seed
    ```

17. **Jalankan Server**
    Jalankan server pengembangan dengan perintah:
    ```bash
    php artisan serve
    ```

18. **Akses Aplikasi**

    Buka browser dan akses aplikasi Geschaft melalui URL berikut: [http://localhost:8000](http://localhost:8000)

### Kredensial Login

Gunakan kredensial berikut untuk masuk ke aplikasi Geschaft:
Email: admin@dev.test
Password: pwd
