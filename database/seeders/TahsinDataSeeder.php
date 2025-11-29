<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahsinClass;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Subscription;
use App\Models\ZoomSession;
use App\Models\ClassSchedule;

class TahsinDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Tahsin Classes
        $class1 = TahsinClass::create([
            'name' => 'Tahsin Anak Reguler',
            'description' => 'Kelas tahsin untuk anak-anak dengan sistem reguler (3-6 peserta). Belajar membaca Al-Quran dengan benar sesuai kaidah tajwid dalam suasana yang menyenangkan.',
            'order' => 1,
            'is_active' => true,
        ]);

        $class2 = TahsinClass::create([
            'name' => 'Tahsin Anak Privat',
            'description' => 'Kelas tahsin privat khusus untuk anak-anak dengan pendampingan personal one-on-one. Pembelajaran intensif dan fokus sesuai kemampuan anak.',
            'order' => 2,
            'is_active' => true,
        ]);

        $class3 = TahsinClass::create([
            'name' => 'Tahsin Reguler (Dewasa)',
            'description' => 'Kelas tahsin untuk umum/dewasa dengan sistem reguler. Memperbaiki bacaan Al-Quran sesuai dengan kaidah tajwid yang benar.',
            'order' => 3,
            'is_active' => true,
        ]);

        $class4 = TahsinClass::create([
            'name' => 'Tahsin Privat (Dewasa)',
            'description' => 'Kelas tahsin privat untuk dewasa dengan metode pembelajaran personal. Jadwal fleksibel dan materi disesuaikan dengan kebutuhan.',
            'order' => 4,
            'is_active' => true,
        ]);

        // Lessons for Tahsin Anak Reguler
        Lesson::create([
            'tahsin_class_id' => $class1->id,
            'title' => 'Perkenalan Huruf Hijaiyah',
            'description' => 'Mengenal huruf-huruf hijaiyah dengan cara yang menyenangkan.',
            'content' => "Assalamu'alaikum adik-adik! Mari kita belajar huruf hijaiyah bersama.\n\nHuruf hijaiyah ada 29 huruf:\nأ ب ت ث ج ح خ د ذ ر ز س ش ص ض ط ظ ع غ ف ق ك ل م ن ه و ي\n\nSetiap huruf punya bunyi yang berbeda. Kita akan belajar satu per satu dengan cara yang seru!\n\nTips untuk adik-adik:\n- Dengarkan baik-baik\n- Tirukan dengan benar\n- Latihan setiap hari\n- Jangan malu bertanya",
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'order' => 1,
        ]);

        Lesson::create([
            'tahsin_class_id' => $class1->id,
            'title' => 'Belajar Harokat: Fathah, Kasrah, Dhammah',
            'description' => 'Memahami tanda baca dasar dalam Al-Quran.',
            'content' => "Harokat adalah tanda baca yang membuat huruf hijaiyah bisa dibaca.\n\nAda 3 harokat dasar:\n1. Fathah ( َ ) - bunyinya 'a' → بَ (ba)\n2. Kasrah ( ِ ) - bunyinya 'i' → بِ (bi)\n3. Dhammah ( ُ ) - bunyinya 'u' → بُ (bu)\n\nYuk latihan:\n- تَ (ta), تِ (ti), تُ (tu)\n- سَ (sa), سِ (si), سُ (su)\n- مَ (ma), مِ (mi), مُ (mu)",
            'order' => 2,
        ]);

        // Lessons for Tahsin Anak Privat
        Lesson::create([
            'tahsin_class_id' => $class2->id,
            'title' => 'Makhorijul Huruf untuk Anak',
            'description' => 'Belajar tempat keluar huruf dengan cara yang mudah dipahami anak.',
            'content' => "Makhorijul huruf artinya tempat keluarnya huruf hijaiyah.\n\nAda 5 tempat utama:\n1. Dari mulut (ا و ي)\n2. Dari tenggorokan (ء ه ع ح غ خ)\n3. Dari lidah (ق ك ج ش ي)\n4. Dari bibir (ب م و ف)\n5. Dari hidung (م ن - bunyi dengung)\n\nKita akan latihan satu per satu sampai benar ya!",
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'order' => 1,
        ]);

        Lesson::create([
            'tahsin_class_id' => $class2->id,
            'title' => 'Latihan Membaca Surat Pendek',
            'description' => 'Praktik membaca surat-surat pendek dengan tajwid yang benar.',
            'content' => "Sekarang kita akan latihan membaca surat pendek:\n\n1. Al-Fatihah\n2. Al-Ikhlas\n3. Al-Falaq\n4. An-Nas\n\nYang penting diperhatikan:\n- Bacaan panjang (mad)\n- Bacaan dengung (ghunnah)\n- Bacaan di bibir\n- Bacaan di tenggorokan\n\nLatihan terus ya adik-adik!",
            'order' => 2,
        ]);

        // Lessons for Tahsin Reguler (Dewasa)
        Lesson::create([
            'tahsin_class_id' => $class3->id,
            'title' => 'Makhorijul Huruf',
            'description' => 'Memahami dan mempraktikkan tempat keluarnya huruf hijaiyah.',
            'content' => "Makhorijul huruf adalah ilmu yang mempelajari tempat keluarnya huruf hijaiyah.\n\nAda 5 tempat keluar huruf:\n1. Al-Jauf (rongga mulut) → حروف المد\n2. Al-Halq (tenggorokan) → ء ه ع ح غ خ\n3. Al-Lisan (lidah) → ق ك ج ش ي ض ل ن ر ط د ت ص ز س ظ ذ ث\n4. Asy-Syafatain (dua bibir) → ب م و ف\n5. Al-Khaisyum (pangkal hidung) → ghunnah\n\nSetiap huruf harus keluar dari makhrajnya yang benar agar bacaan Al-Quran kita sesuai kaidah.",
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'order' => 1,
        ]);

        Lesson::create([
            'tahsin_class_id' => $class3->id,
            'title' => 'Sifatul Huruf',
            'description' => 'Mempelajari sifat-sifat huruf hijaiyah.',
            'content' => "Sifatul huruf adalah karakteristik yang membedakan satu huruf dengan huruf lainnya.\n\nDibagi menjadi 2 kategori:\n\n1. Sifat yang memiliki lawan (10 pasang):\n   - Hams ↔ Jahr\n   - Syiddah ↔ Rakhawah\n   - Isti'la ↔ Istifal\n   - Ithbaq ↔ Infitah\n   - Idzlaq ↔ Ishmat\n\n2. Sifat yang tidak memiliki lawan (7 sifat):\n   - Shofir, Qolqolah, Liin, Inhiraf, Takrir, Tafasysyi, Istitholah\n\nMemahami sifat huruf sangat penting untuk membaca Al-Quran dengan benar.",
            'order' => 2,
        ]);

        Lesson::create([
            'tahsin_class_id' => $class3->id,
            'title' => 'Ahkamul Mad',
            'description' => 'Hukum-hukum bacaan panjang dalam Al-Quran.',
            'content' => "Mad (المد) artinya memanjangkan.\n\nJenis-jenis mad:\n\n1. Mad Thobi'i (2 harakat)\n2. Mad Wajib Muttashil (4-5 harakat)\n3. Mad Jaiz Munfashil (2-5 harakat)\n4. Mad 'Aridh Lissukun (2-6 harakat)\n5. Mad Lazim (6 harakat)\n6. Mad 'Iwadh (2 harakat)\n7. Mad Shilah (2 harakat)\n\nSetiap jenis mad memiliki aturan dan kadar panjang yang berbeda.",
            'order' => 3,
        ]);

        // Lessons for Tahsin Privat (Dewasa)
        Lesson::create([
            'tahsin_class_id' => $class4->id,
            'title' => 'Evaluasi Bacaan Personal',
            'description' => 'Analisis dan perbaikan bacaan Al-Quran secara individual.',
            'content' => "Dalam sesi privat ini, kita akan:\n\n1. Evaluasi bacaan Anda saat ini\n2. Identifikasi kesalahan yang sering terjadi\n3. Perbaikan bertahap sesuai prioritas\n4. Latihan intensif pada bagian yang lemah\n\nYang akan diperbaiki:\n- Makhorijul huruf yang belum tepat\n- Sifatul huruf yang kurang jelas\n- Ahkamul mad yang belum sesuai\n- Ghunnah dan qolqolah\n- Waqaf dan ibtida'\n\nSetiap siswa mendapat program perbaikan yang disesuaikan.",
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'order' => 1,
        ]);

        Lesson::create([
            'tahsin_class_id' => $class4->id,
            'title' => 'Tajwid Lanjutan',
            'description' => 'Pembahasan mendalam tentang kaidah tajwid tingkat lanjut.',
            'content' => "Materi tajwid lanjutan:\n\n1. Ahkamun Nun Sakinah & Tanwin\n   - Idghar\n   - Iqlab\n   - Ikhfa'\n   - Idhar\n\n2. Ahkamul Mim Sakinah\n   - Ikhfa' Syafawi\n   - Idgham Mitsli\n   - Idhar Syafawi\n\n3. Qolqolah (الْقَلْقَلَة)\n   - Qolqolah Kubra\n   - Qolqolah Shughra\n\n4. Ra' Tafkhim & Tarqiq\n5. Lam Tafkhim & Tarqiq\n6. Waqaf & Ibtida'\n\nDipelajari dengan praktik langsung dan koreksi detail.",
            'order' => 2,
        ]);

        // Create a dummy student with active subscription
        $student = User::create([
            'name' => 'Muhammad Ahmad',
            'phone' => '081234567890',
            'password' => bcrypt('password'),
            'role' => 'student',
            'tahsin_class_id' => $class3->id, // Enrolled in Tahsin Reguler (Dewasa)
        ]);

        Subscription::create([
            'user_id' => $student->id,
            'start_date' => now(),
            'end_date' => now()->addDays(28),
            'status' => 'active',
        ]);

        // Create Zoom Sessions
        // Live session for Tahsin Anak Reguler
        ZoomSession::create([
            'tahsin_class_id' => $class1->id,
            'title' => 'Pertemuan Reguler - Belajar Huruf Hijaiyah',
            'zoom_link' => 'https://zoom.us/j/1234567890',
            'meeting_id' => '123 456 7890',
            'passcode' => 'tahsin123',
            'scheduled_at' => now()->subMinutes(10), // Started 10 minutes ago
            'duration_minutes' => 60,
            'status' => 'live',
            'description' => 'Kelas reguler untuk anak-anak belajar huruf hijaiyah',
        ]);

        // Upcoming session for Tahsin Reguler (Dewasa)
        ZoomSession::create([
            'tahsin_class_id' => $class3->id,
            'title' => 'Sesi Makhorijul Huruf',
            'zoom_link' => 'https://zoom.us/j/9876543210',
            'meeting_id' => '987 654 3210',
            'passcode' => 'tajwid456',
            'scheduled_at' => now()->addHours(2), // 2 hours from now
            'duration_minutes' => 90,
            'status' => 'scheduled',
            'description' => 'Pembelajaran mendalam tentang makhorijul huruf',
        ]);

        // Another upcoming for Tahsin Privat
        ZoomSession::create([
            'tahsin_class_id' => $class4->id,
            'title' => 'Sesi Privat - Evaluasi Personal',
            'zoom_link' => 'https://zoom.us/j/5555555555',
            'meeting_id' => '555 555 5555',
            'passcode' => 'privat789',
            'scheduled_at' => now()->addDay(), // Tomorrow
            'duration_minutes' => 60,
            'status' => 'scheduled',
            'description' => 'Evaluasi bacaan personal one-on-one',
        ]);

        // Completed session
        ZoomSession::create([
            'tahsin_class_id' => $class2->id,
            'title' => 'Latihan Surat Pendek',
            'zoom_link' => 'https://zoom.us/j/1111111111',
            'meeting_id' => '111 111 1111',
            'passcode' => 'selesai',
            'scheduled_at' => now()->subDays(2),
            'duration_minutes' => 45,
            'status' => 'completed',
            'description' => 'Latihan membaca surat-surat pendek',
        ]);

        // Create Class Schedules (2 meetings per week for each class)
        // Tahsin Anak Reguler - Senin & Kamis (16:00-17:00)
        ClassSchedule::create([
            'tahsin_class_id' => $class1->id,
            'day_of_week' => 'senin',
            'time_start' => '16:00:00',
            'time_end' => '17:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);
        ClassSchedule::create([
            'tahsin_class_id' => $class1->id,
            'day_of_week' => 'kamis',
            'time_start' => '16:00:00',
            'time_end' => '17:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);

        // Tahsin Anak Privat - Selasa & Jumat (16:00-17:00)
        ClassSchedule::create([
            'tahsin_class_id' => $class2->id,
            'day_of_week' => 'selasa',
            'time_start' => '16:00:00',
            'time_end' => '17:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);
        ClassSchedule::create([
            'tahsin_class_id' => $class2->id,
            'day_of_week' => 'jumat',
            'time_start' => '16:00:00',
            'time_end' => '17:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);

        // Tahsin Reguler Dewasa - Senin & Kamis (19:00-21:00)
        ClassSchedule::create([
            'tahsin_class_id' => $class3->id,
            'day_of_week' => 'senin',
            'time_start' => '19:00:00',
            'time_end' => '21:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);
        ClassSchedule::create([
            'tahsin_class_id' => $class3->id,
            'day_of_week' => 'kamis',
            'time_start' => '19:00:00',
            'time_end' => '21:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);

        // Tahsin Privat Dewasa - Selasa & Jumat (19:00-21:00)
        ClassSchedule::create([
            'tahsin_class_id' => $class4->id,
            'day_of_week' => 'selasa',
            'time_start' => '19:00:00',
            'time_end' => '21:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);
        ClassSchedule::create([
            'tahsin_class_id' => $class4->id,
            'day_of_week' => 'jumat',
            'time_start' => '19:00:00',
            'time_end' => '21:00:00',
            'is_active' => true,
            'week_start_date' => now()->startOfWeek(),
            'created_by' => 1,
        ]);

        echo "✅ Data dummy berhasil dibuat!\n";
        echo "- 4 Kelas Tahsin (Anak Reguler, Anak Privat, Reguler Dewasa, Privat Dewasa)\n";
        echo "- 10 Lessons\n";
        echo "- 8 Class Schedules (2 meetings/week per class)\n";
        echo "- 4 Zoom Sessions (1 Live, 2 Upcoming, 1 Completed)\n";
        echo "- 1 Student dengan langganan aktif (081234567890 / password)\n";
    }
}
