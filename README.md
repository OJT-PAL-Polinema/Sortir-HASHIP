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
Ada dua cara untuk menginstal proyek ini, silakan pilih salah satu.

---
#### **Jalur A: Instalasi via `git clone` (Direkomendasikan)**
Ikuti semua langkah ini dari awal jika Anda meng-clone repositori.

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/OJT-PAL-Polinema/Sortir-HASHIP.git](https://github.com/OJT-PAL-Polinema/Sortir-HASHIP.git)
    cd Sortir-HASHIP
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Buat File Environment**
    ```bash
    copy .env.example .env
    ```

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda (nama database, username, password).
    ```env
    DB_DATABASE=sortir
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Setup Database (Pilih Salah Satu Opsi)**

    * **Opsi 1 (Cepat): Import SQL**
        1.  Buat database baru bernama `sortir`.
        2.  Import file `sortir.sql` yang sudah disediakan.

    * **Opsi 2 (Standar): Migrasi & Seeding**
        1.  Buat database baru bernama `sortir`.
        2.  Jalankan `php artisan migrate`
        3.  Jalankan `php artisan db:seed`

7.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```

---
#### **Jalur B: Instalasi via File ZIP**
Gunakan jalur ini jika Anda mengunduh proyek dalam bentuk file `.zip`.

1.  **Ekstrak File ZIP**
    Ekstrak semua isi file `Sortir-HASHIP.zip` ke folder tujuan Anda.

2.  **Lewati Langkah Awal**
    Anda bisa **melewatkan langkah 1 sampai 5** dari "Jalur A" karena file `.env` dan folder `vendor` sudah disertakan. Langsung lanjutkan ke:

3.  **Setup Database (Langkah 6 dari Jalur A)**
    Pastikan pengaturan di file `.env` Anda sudah benar, lalu lakukan salah satu dari dua opsi berikut:
    * **Opsi 1 (Cepat):** Buat database `sortir` dan import file `sortir.sql`.
    * **Opsi 2 (Standar):** Buat database `sortir`, lalu jalankan `php artisan migrate --seed`.

4.  **Jalankan Aplikasi (Langkah 7 dari Jalur A)**
    ```bash
    php artisan serve
    ```
---
## Penggunaan 🚀

Aplikasi ini memiliki dua tingkat akses:

#### **Sebagai Tamu (Tanpa Login)**
* Anda dapat langsung mengakses halaman daftar IP dan Hash. Ada dua cara untuk melakukannya:
    1.  Ketik langsung alamatnya di browser: `http://127.0.0.1:8000/ips` atau `http://127.0.0.1:8000/hashes`.
    2.  Buka halaman `http://127.0.0.1:8000/login` dan gunakan tombol navigasi **"IP"** atau **"HASH"** di bagian header.

#### **Sebagai Admin (Setelah Login)**
* Buka halaman login di `http://127.0.0.1:8000/login`.
* Gunakan kredensial berikut untuk masuk:
    * **Username**: `admin`
    * **Password**: `admin`
* Setelah login, Anda akan diarahkan ke halaman *dashboard* (`/home`).
* Di halaman ini, Anda dapat menggunakan form untuk mengunggah file CSV yang berisi daftar IP atau Hash baru.