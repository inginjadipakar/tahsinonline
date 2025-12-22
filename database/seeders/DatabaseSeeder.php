<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TahsinClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Pastikan Data Kelas Tahsin ada
        $this->call([
            TahsinDataSeeder::class, 
        ]);

        // 2. Hapus user dummy dari TahsinDataSeeder, ganti dengan akun kita
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil ID kelas Tahsin Dewasa Reguler
        $tahsinDewasa = TahsinClass::where('name', 'like', '%Reguler%Dewasa%')->first();

        // 3. Buat Akun Admin
        User::create([
            'name' => 'Admin Utama',
            'phone' => '6282230466573',
            'password' => Hash::make('mjsmulia24'),
            'role' => 'admin',
            'gender' => 'male',
            'address' => 'Kantor Admin',
            'occupation' => 'Administrator',
            'age' => 30,
        ]);

        // 4. Buat Akun User (Siswa)
        User::create([
            'name' => 'Siswa Baru',
            'phone' => '628813224569',
            'password' => Hash::make('mjsmulia24'),
            'role' => 'student',
            'tahsin_class_id' => $tahsinDewasa ? $tahsinDewasa->id : 1,
            'gender' => 'male',
            'address' => 'Surabaya',
            'occupation' => 'Pegawai Swasta',
            'age' => 25,
            'is_child_account' => false,
        ]);

        // 5. Buat Akun Guru
        User::create([
            'name' => 'Ustadz Pengajar',
            'phone' => '6281216861835',
            'password' => Hash::make('mjsmulia24'),
            'role' => 'teacher',
            'gender' => 'male',
            'address' => 'Rumah Guru',
            'occupation' => 'Pengajar Al-Quran',
            'age' => 35,
        ]);

        echo "✅ Akun berhasil dibuat:\n";
        echo "- Admin: 6282230466573 (pass: mjsmulia24)\n";
        echo "- Siswa: 628813224569 (pass: mjsmulia24)\n";
        echo "- Guru: 6281216861835 (pass: mjsmulia24)\n";
    }
}
