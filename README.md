SmartAssets 📦

<p align="center">
<strong>Aplikasi Manajemen Inventaris Sekolah Berbasis Web</strong>
</p>

<p align="center">
<a href="#-fitur-utama">Fitur</a> •
<a href="#-tech-stack">Teknologi</a> •
<a href="#-setup-database--instalasi">Instalasi</a> •
<a href="#-dokumentasi-aplikasi">Dokumentasi</a>
</p>

📖 Tentang Aplikasi

SmartAssets adalah aplikasi manajemen aset berbasis web yang dirancang untuk mempermudah pengelolaan data barang (inventaris) sekolah atau organisasi. Aplikasi ini menyediakan fitur CRUD (Create, Read, Update, Delete) yang lengkap, autentikasi pengguna yang aman, serta antarmuka yang modern dan responsif.

Dibangun dengan kekuatan Laravel 10 dan keindahan Tailwind CSS, proyek ini menawarkan pengalaman pengguna yang cepat, intuitif, dan mudah diakses melalui berbagai perangkat.

✨ Fitur Utama

🔐 Autentikasi Aman: Sistem Login dan Register terintegrasi untuk keamanan akses data.

📊 Dashboard Interaktif: Ringkasan statistik visual (Total Item, Stok Masuk/Keluar, Nilai Aset) dengan grafik dinamis.

📱 Desain Responsif: Tampilan sidebar dan layout yang menyesuaikan layar Desktop, Tablet, dan Mobile.

🛠 Manajemen Item (CRUD):

Tambah, Edit, Hapus, dan Lihat Detail Barang.

Pencarian dan Filter data barang.

Penyimpanan informasi detail (Kode, Nama, Kategori, Kondisi, Lokasi).

📂 Manajemen Data Master: Pengelolaan Kategori Barang dan Kondisi Barang (Baik, Rusak, dll).

👤 Profil Pengguna: Kustomisasi profil, foto profil, kontak, dan preferensi tema.

🔔 Notifikasi: Flash messages interaktif untuk notifikasi sukses atau gagal saat melakukan aksi.

🗂 Entitas Utama

Struktur data aplikasi ini dibangun di atas entitas berikut:

Entitas

Deskripsi

Relasi

Users

Menyimpan data autentikasi (nama, email, password).

Utama

Profiles

Data pelengkap (foto, kontak, sosmed, preferensi).

One-to-One ke User

Categories

Jenis pengelompokan barang (Misal: Elektronik, Mebel).

One-to-Many ke Items

Conditions

Status fisik barang (Misal: Baik, Rusak).

One-to-Many ke Items

Items

Data inti inventaris (Kode, Nama, Jumlah, Lokasi).

Belongs To Category & Condition

🛠 Tech Stack

Framework: Laravel 10 (PHP)

Styling: Tailwind CSS

Database: MySQL

Templating: Blade Templates

Scripting: JavaScript (Chart.js, Vanilla JS)

Icons: FontAwesome

🚀 Setup Database & Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal Anda:

1. Clone Repository

git clone [https://github.com/username-anda/smartassets.git](https://github.com/username-anda/smartassets.git)
cd smartassets


2. Install Dependencies

Instal paket PHP dan Node.js yang diperlukan:

composer install
npm install


3. Konfigurasi Environment

Duplikat file .env.example menjadi .env dan sesuaikan konfigurasi database Anda:

cp .env.example .env


Buka file .env dan atur kredensial database:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartassets  # Pastikan database ini sudah dibuat di MySQL
DB_USERNAME=root
DB_PASSWORD=


4. Generate Key & Migrasi Database

Jalankan perintah berikut untuk membuat key aplikasi, tabel database, dan symbolic link penyimpanan gambar:

php artisan key:generate
php artisan migrate
php artisan storage:link


5. Jalankan Aplikasi

Buka dua terminal terpisah untuk menjalankan server Laravel dan Vite (untuk CSS/JS):

# Terminal 1
php artisan serve

# Terminal 2
npm run dev


Buka http://localhost:8000 di browser Anda.

📸 Dokumentasi Aplikasi

Berikut adalah tampilan antarmuka dari aplikasi SmartAssets:

1. Dashboard & Statistik

Halaman utama menampilkan ringkasan statistik dan grafik inventaris.

2. Halaman Login

Halaman autentikasi untuk masuk ke dalam sistem.

3. Halaman Register

Halaman pendaftaran untuk pengguna baru.

4. Daftar Data (Inventory)

Halaman utama pengelolaan barang dengan fitur pencarian.

5. Manajemen Kategori

Halaman untuk mengatur pengelompokan barang.

6. Kondisi Barang

Halaman untuk mengatur status fisik barang.

7. Pengaturan Profil (Settings)

Halaman untuk mengubah foto profil dan informasi kontak.

8. Pusat Bantuan (Help)

Halaman FAQ dan panduan penggunaan.
