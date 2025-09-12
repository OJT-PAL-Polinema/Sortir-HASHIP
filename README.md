# Sortir IP/Hash - Aplikasi Manajemen Blocklist

Sebuah aplikasi web sederhana yang dibangun dengan Laravel untuk mengelola daftar blocklist alamat IP dan nilai Hash. Aplikasi ini memungkinkan pengguna untuk mengunggah file CSV, memvalidasi isinya, menyimpannya ke database tanpa duplikasi, dan menampilkannya dalam daftar publik.

---
## Fitur Utama ✨
* **Otentikasi Pengguna**: Sistem login untuk administrator yang ingin mengelola data.
* **Upload File CSV**: Mengunggah daftar IP atau Hash dengan mudah melalui file `.csv` atau `.txt`.
* **Deduplikasi Otomatis**: Sistem secara otomatis akan menolak data yang sudah ada di dalam database, hanya menyimpan entri yang unik.
* **Validasi Konten**: Aplikasi akan memeriksa beberapa baris pertama file untuk memastikan isinya sesuai dengan tipe data yang dipilih (IP atau Hash).
* **Notifikasi Detail**: Setelah upload, sistem akan memberikan laporan jumlah data baru yang ditambahkan dan jumlah duplikat yang ditemukan.
* **Tampilan Publik**: Siapa pun dapat melihat daftar IP dan Hash yang sudah tersimpan tanpa perlu login.

---
## Teknologi 
* Laravel
* PHP
* MySQL / MariaDB

---
## Instalasi & Konfigurasi ⚙️

Berikut adalah langkah-langkah untuk menjalankan aplikasi ini di lingkungan lokal.

1.  **Clone Repository**
    ```bash
    git clone https://github.com/OJT-PAL-Polinema/Sortir-HASHIP.git
    cd Sortir-HASHIP
    ```

2.  **Install Dependencies**
    Jalankan perintah Composer untuk menginstal semua paket yang dibutuhkan.
    ```bash
    composer install
    ```

3.  **Buat File Environment**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    copy .env.example .env
    ```

4.  **Generate Application Key**
    Buat kunci enkripsi unik untuk aplikasi Anda.
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sortir
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Setup Database (Pilih Salah Satu Opsi)**

    #### **Opsi A (Cepat): Import SQL**
    Cara ini menggunakan file `.sql` yang sudah berisi struktur tabel dan data user admin.
    1.  Buat database baru di MySQL/phpMyAdmin dengan nama **`sortir`**.
    2.  Import file **`sortir.sql`** yang sudah disediakan ke dalam database tersebut.

    #### **Opsi B (Standar): Migrasi & Seeding**
    Cara ini membuat struktur tabel dan data awal dari kode Laravel.
    1.  Buat database baru di MySQL/phpMyAdmin dengan nama **`sortir`**.
    2.  Jalankan migrasi untuk membuat semua tabel.
        ```bash
        php artisan migrate
        ```
    3.  Jalankan seeder untuk membuat data user admin.
        ```bash
        php artisan db:seed
        ```

7.  **Jalankan Aplikasi**
    Jalankan server development lokal Laravel.
    ```bash
    php artisan serve
    ```
    Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

---
## Penggunaan 🚀

Aplikasi ini memiliki dua tingkat akses:

#### **Sebagai Tamu (Tanpa Login)**
* Anda dapat langsung mengakses halaman daftar IP dan Hash.
    * Buka `http://127.0.0.1:8000/ips` untuk melihat daftar IP.
    * Buka `http://127.0.0.1:8000/hashes` untuk melihat daftar Hash.

#### **Sebagai Admin (Setelah Login)**
* Buka halaman login di `http://127.0.0.1:8000/login`.
* Gunakan kredensial berikut untuk masuk:
    * **Username**: `admin`
    * **Password**: `admin`
* Setelah login, Anda akan diarahkan ke halaman *dashboard* (`/home`).
* Di halaman ini, Anda dapat menggunakan form untuk mengunggah file CSV yang berisi daftar IP atau Hash baru.