# 📖 Hafalanqu

Aplikasi web Laravel untuk memantau dan mencatat setoran hafalan Al-Qur'an oleh santri. Sistem ini dilengkapi dengan 3 peran utama: **Admin**, **Ustad**, dan **Santri**.

Tampilan menggunakan **Modernize Admin Template** yang responsif dan modern.

---

## ✨ Fitur Utama

-   ✅ Login & Register dengan Role (`admin`, `ustad`, `santri`)
-   📋 Input setoran hafalan
-   🎧 Upload file hafalan (audio .mp3)
-   📊 Laporan dan rekap hafalan santri
-   👨‍🏫 Ustad dapat mengecek dan menilai hafalan santri
-   🔐 Admin dapat mengelola data santri, ustad, kelas, dan halaqoh

---

## 🛠️ Teknologi yang Digunakan

-   Laravel 10.x
-   MySQL / MariaDB
-   Blade Templating Engine
-   Modernize Admin Template (HTML5 + Bootstrap 5)
-   Select2, jQuery
-   File upload audio

---

## ⚙️ Instalasi

### 1. Clone Proyek

```bash
git clone https://github.com/azrildelfrian/Laravel-Tahfidz-Quran.git
cd Laravel-Tahfidz-Quran
```

### 2. Install Dependency

```bash
composer install
npm install && npm run dev
```

### 3. Buat File `.env`

```bash
cp .env.example .env
```

Edit konfigurasi database:

```env
DB_DATABASE=hafalanqu
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key

```bash
php artisan key:generate
```

### 5. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

### 6. Jalankan Server

```bash
php artisan serve
```

---

## 🔐 Akun Demo (Seeder)

| Role   | Email            | Password  |
| ------ | ---------------- | --------- |
| Admin  | admin@gmail.com  | admin123  |
| Ustad  | ustad@gmail.com  | ustad123  |
| Santri | santri@gmail.com | santri123 |

---

## 📁 Struktur Folder Penting

-   `app/Models` – Model data seperti `Santri`, `Hafalan`, `Surat`, `User`
-   `app/Http/Controllers` – Logika dan alur backend
-   `resources/views/pages` – Blade view halaman utama
-   `routes/web.php` – Routing aplikasi

---

## 📷 Screenshot

Berikut adalah cuplikan antarmuka dari aplikasi **Hafalanqu** berdasarkan peran pengguna:

---

### 🔐 Login

![Login](/screenshot/Hafalanqu-Login.png)

---

### 🧑‍💼 Admin

-   **Dashboard**  
    ![Admin Dashboard](/screenshot/Admin-Dashboard.png)

-   **Daftar Hafalan**  
    ![Admin Daftar Hafalan](/screenshot/Admin-DaftarHafalan.png)

-   **Detail Hafalan**  
    ![Admin Detail](/screenshot/Admin-Detail.png)

-   **Data Halaqoh**  
    ![Admin Halaqoh](/screenshot/Admin-Halaqoh.png)

-   **Data Kelas**  
    ![Admin Kelas](/screenshot/Admin-Kelas.png)

-   **Data Santri**  
    ![Admin Santri](/screenshot/Admin-Santri.png)

-   **Data Ustad**  
    ![Admin Ustad](/screenshot/Admin-Ustad.png)

---

### 🧑‍🏫 Ustad

-   **Dashboard**  
    ![Ustad Dashboard](/screenshot/Ustad-Dashboard.png)

-   **Detail Hafalan Santri**  
    ![Ustad Detail](/screenshot/Ustad-Detail.png)

-   **Periksa Hafalan**  
    ![Ustad Periksa](/screenshot/Ustad-Periksa.png)

---

### 🧑‍🎓 Santri

-   **Dashboard**  
    ![Santri Dashboard](/screenshot/Santri-Dashboard.png)

-   **Tambah Hafalan**  
    ![Santri Revisi](/screenshot/Santri-Tambah.png)

-   **Revisi Hafalan**  
    ![Santri Revisi](/screenshot/Santri-Revisi.png)

-   **Riwayat Hafalan**  
    ![Santri Riwayat](/screenshot/Santri-Riwayat.png)

---

## 🤝 Kontribusi

1. Fork proyek ini
2. Buat branch fitur (`feature/nama-fitur`)
3. Commit perubahan
4. Push dan buat Pull Request

---

## 📄 Lisensi

Proyek ini berlisensi MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.
