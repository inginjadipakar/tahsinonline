<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\TahsinClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Base lessons template - will be applied to all classes
        $baseLessons = [
            [
                'title' => 'Pertemuan 1: Pengenalan Makharijul Huruf',
                'description' => 'Mempelajari dasar-dasar tempat keluarnya huruf hijaiyah',
                'order' => 1,
            ],
            [
                'title' => 'Pertemuan 2: Huruf-huruf Halqi (Tenggorokan)',
                'description' => 'Mempelajari huruf yang keluar dari tenggorokan: ء ه ع ح غ خ',
                'order' => 2,
            ],
            [
                'title' => 'Pertemuan 3: Huruf-huruf Lisan (Lidah) Bagian 1',
                'description' => 'Mempelajari huruf: ق ك ج ش ي ض',
                'order' => 3,
            ],
            [
                'title' => 'Pertemuan 4: Huruf-huruf Lisan (Lidah) Bagian 2',
                'description' => 'Mempelajari huruf: ل ن ر ط د ت ص ز س ظ ذ ث',
                'order' => 4,
            ],
            [
                'title' => 'Pertemuan 5: Huruf-huruf Syafatain (Bibir)',
                'description' => 'Mempelajari huruf yang keluar dari bibir: ف و ب م',
                'order' => 5,
            ],
            [
                'title' => 'Pertemuan 6: Sifatul Huruf - Hams & Jahr',
                'description' => 'Mempelajari sifat huruf bisik (hams) dan keras (jahr)',
                'order' => 6,
            ],
            [
                'title' => 'Pertemuan 7: Sifatul Huruf - Syiddah & Rakhawah',
                'description' => 'Mempelajari sifat huruf kuat (syiddah) dan lemah (rakhawah)',
                'order' => 7,
            ],
            [
                'title' => 'Pertemuan 8: Hukum Nun Mati & Tanwin',
                'description' => 'Izhar, Idgham, Iqlab, dan Ikhfa',
                'order' => 8,
            ],
            [
                'title' => 'Pertemuan 9: Hukum Mim Mati',
                'description' => 'Izhar Syafawi, Idgham Mimi, dan Ikhfa Syafawi',
                'order' => 9,
            ],
            [
                'title' => 'Pertemuan 10: Hukum Mad (Panjang Bacaan)',
                'description' => 'Mad Asli, Mad Far\'i, dan pembagiannya',
                'order' => 10,
            ],
            [
                'title' => 'Pertemuan 11: Qalqalah & Ghunnah',
                'description' => 'Mempelajari huruf yang memantul dan dengung',
                'order' => 11,
            ],
            [
                'title' => 'Pertemuan 12: Praktik Membaca Al-Quran',
                'description' => 'Praktik langsung membaca surat-surat pendek dengan tajwid yang benar',
                'order' => 12,
            ],
        ];

        // Get all tahsin classes and add lessons
        $classes = TahsinClass::all();

        foreach ($classes as $class) {
            // Check if class already has lessons
            if ($class->lessons()->count() > 0) {
                $this->command->info("Skipping {$class->name} - already has lessons");
                continue;
            }

            foreach ($baseLessons as $lesson) {
                Lesson::create([
                    'tahsin_class_id' => $class->id,
                    'title' => $lesson['title'],
                    'description' => $lesson['description'],
                    'order' => $lesson['order'],
                ]);
            }

            $this->command->info("Added 12 lessons to {$class->name}");
        }
    }
}
