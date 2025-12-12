# 👨‍🏫 Panduan Pengembangan LMS Guru (Teacher Portal)

Halo! Dokumen ini dibuat khusus untuk membantu Anda memulai pengembangan fitur **Halaman Guru** di Tahsin Online.

## 🏗️ Apa yang Sudah Siap?
Saya (AI Assistant) sudah menyiapkan pondasi teknis agar Anda bisa langsung fokus ke fitur:

1.  **Middleware Keamanan (`TeacherOnly`)**
    *   Lokasi: `app/Http/Middleware/TeacherOnly.php`
    *   Fungsi: Memastikan hanya user dengan `role = 'teacher'` yang bisa mengakses halaman ini.

2.  **Routing Group**
    *   Lokasi: `routes/web.php` (Bagian bawah)
    *   Status: Sudah ada grup route dengan prefix `/teacher` dan name `teacher.`.

## 🚀 Langkah 1: Buat Akun Guru (Untuk Testing)
Karena tidak ada halaman registrasi publik untuk guru, Anda perlu membuat akun guru secara manual lewat database atau Tinker.

**Cara Cepat (via Terminal):**
```bash
php artisan tinker
```
Lalu ketik perintah ini:
```php
\App\Models\User::create([
    'name' => 'Guru Test',
    'phone' => '081234567890', // Username login
    'password' => bcrypt('password'),
    'role' => 'teacher', // PENTING!
    'gender' => 'male',
    'age' => 30,
    'address' => 'Kantor Guru',
    'occupation' => 'Pengajar'
]);
```
*Login dengan No HP: `081234567890` dan Password: `password`*

## 🛠️ Langkah 2: Mulai Coding

### 1. Buat Controller
Buat controller baru untuk dashboard guru.
```bash
php artisan make:controller Teacher/DashboardController
```

### 2. Update Route
Buka `routes/web.php` dan ubah placeholder yang saya buat:

```php
// routes/web.php

use App\Http\Controllers\Teacher\DashboardController; // Jangan lupa import

Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    
    // Dashboard Guru
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tambahkan route lain di sini, misal:
    // Route::resource('assessments', AssessmentController::class);
});
```

### 3. Buat View
Buat file view di `resources/views/teacher/dashboard.blade.php`.
Anda bisa copy layout dari admin atau student agar konsisten.

```html
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang, Ustadz! Silakan input nilai santri.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

## 💡 Ide Fitur untuk Dikerjakan
Berikut adalah fitur-fitur yang biasanya dibutuhkan di LMS Guru:
1.  **Input Nilai / Mutabaah:** Form untuk memasukkan perkembangan bacaan siswa per pertemuan.
2.  **Absensi:** Menandai kehadiran siswa di kelas.
3.  **Jadwal Mengajar:** Menampilkan jadwal kelas yang diampu (bisa ambil relasi dari `TahsinClass`).

Selamat berkarya! Jika butuh bantuan, tanya saja ke Project Manager (User). 🚀

## 💡 Pro Tips untuk Developer
Agar pekerjaan Anda lebih cepat dan rapi:

### 1. Model yang Sering Dipakai
Anda akan banyak berinteraksi dengan tabel-tabel ini:
*   `\App\Models\TahsinClass`: Data kelas (nama kelas, harga).
*   `\App\Models\User`: Data siswa (cek `role = 'student'` dan `tahsin_class_id`).
*   `\App\Models\ClassSchedule`: Jadwal belajar.
*   `\App\Models\UserProgress`: Untuk mencatat progres belajar siswa.

### 2. Gunakan Komponen UI Bawaan
Jangan bikin style dari nol! Gunakan komponen Blade yang sudah ada agar tampilan konsisten:
*   `<x-app-layout>`: Layout utama dashboard.
*   `<x-primary-button>`: Tombol utama (warna gelap/hijau).
*   `<x-text-input>`: Input form standar.
*   `<x-table>`: (Jika ada) atau copy style table dari halaman Admin.

### 3. Git Workflow (PENTING!)
Agar kode utama (`main`) tetap aman dan tidak error, ikuti langkah ini setiap mau bikin fitur baru:

**A. Persiapan**
1.  Pastikan ada di branch main: `git checkout main`
2.  Ambil update terbaru: `git pull origin main`

**B. Mulai Kerja**
3.  Buat branch baru (nama bebas, deskriptif): `git checkout -b fitur-dashboard-guru`
4.  Silakan coding di branch ini sesuka hati.

**C. Simpan Pekerjaan**
5.  Simpan perubahan:
    ```bash
    git add .
    git commit -m "Menambahkan dashboard guru"
    ```

**D. Setor Pekerjaan**
6.  Upload branch Anda: `git push origin fitur-dashboard-guru`
7.  Buka GitHub, lalu buat **Pull Request (PR)** ke branch `main`.
8.  Kabari Project Manager untuk di-review.

