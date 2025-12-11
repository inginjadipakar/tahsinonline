<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TahsinClass;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get Classes
        $reguler = TahsinClass::where('name', 'Tahsin Anak Reguler')->first();
        $privatAnak = TahsinClass::where('name', 'Tahsin Anak Privat')->first();
        $dewasa = TahsinClass::where('name', 'Tahsin Reguler (Dewasa)')->first();
        $privatDewasa = TahsinClass::where('name', 'Tahsin Privat (Dewasa)')->first();

        if (!$reguler || !$dewasa || !$privatDewasa) {
            $this->command->error('Required classes not found. Please run TahsinClassesSeeder first.');
            return;
        }

        // ==========================================
        // 2. Create Ustadzah Himmah (Multi-Class Teacher)
        // ==========================================
        $ustadimmah = User::create([
            'name' => 'Ustadzah Himmah',
            'phone' => '081216861835',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'gender' => 'female',
            'address' => 'Jakarta',
            'assigned_class_id' => $reguler->id, // Default/Primary class
        ]);

        // Attach 3 classes: Reguler, Dewasa, Privat Dewasa
        $ustadimmah->assignedClasses()->attach([
            $reguler->id,
            $dewasa->id,
            $privatDewasa->id
        ]);

        $this->command->info("✅ Created Ustadzah Himmah (3 Classes)");

        // ==========================================
        // 3. Create Specific Students for Ustadzah Himmah
        // ==========================================

        // A. Kelas Reguler (4 Siswa)
        $siswaReguler = ['Srinurweni', 'Ria Filisita', 'Sri Hartini', 'Nur Aini'];
        foreach ($siswaReguler as $nama) {
            User::create([
                'name' => $nama,
                'phone' => '0812' . rand(10000000, 99999999),
                'password' => Hash::make('password'),
                'role' => 'student',
                'tahsin_class_id' => $reguler->id,
                'gender' => 'female',
            ]);
        }
        $this->command->info("✅ Create 4 Students for Reguler");

        // B. Kelas Dewasa (1 Siswa)
        User::create([
            'name' => 'Ashiva Faranas',
            'phone' => '0812' . rand(10000000, 99999999),
            'password' => Hash::make('password'),
            'role' => 'student',
            'tahsin_class_id' => $dewasa->id,
            'gender' => 'female',
        ]);
        $this->command->info("✅ Create 1 Student for Dewasa");

        // C. Kelas Privat (1 Siswa)
        User::create([
            'name' => 'Susi',
            'phone' => '0812' . rand(10000000, 99999999),
            'password' => Hash::make('password'),
            'role' => 'student',
            'tahsin_class_id' => $privatDewasa->id,
            'gender' => 'female',
        ]);
        // D. Kelas Anak Privat (1 Siswa) - NEW
        User::create([
            'name' => 'Budi Santoso',
            'phone' => '0812' . rand(10000000, 99999999),
            'password' => Hash::make('password'),
            'role' => 'student',
            'tahsin_class_id' => $privatAnak->id,
            'gender' => 'male',
        ]);
        $this->command->info("✅ Create 1 Student for Anak Privat");

        // ==========================================
        // 4. Create Other Teachers (All Access)
        // ==========================================

        // Teacher A
        $teacherA = User::create([
            'name' => 'Ustadz Ahmad',
            'phone' => '081234567801',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'gender' => 'male',
            'assigned_class_id' => $reguler->id,
        ]);
        // Attach ALL classes to Teacher A
        $teacherA->assignedClasses()->attach([$reguler->id, $dewasa->id, $privatAnak->id, $privatDewasa->id]);

        // Teacher B
        $teacherB = User::create([
            'name' => 'Ustadzah Fatimah',
            'phone' => '081234567802',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'gender' => 'female',
            'assigned_class_id' => $privatAnak->id,
        ]);
        // Attach ALL classes to Teacher B
        $teacherB->assignedClasses()->attach([$reguler->id, $dewasa->id, $privatAnak->id, $privatDewasa->id]);

        // Update Ustadzah Himmah to also have ALL classes (adding privatAnak)
        $ustadimmah->assignedClasses()->sync([$reguler->id, $dewasa->id, $privatAnak->id, $privatDewasa->id]);

        // ==========================================
        // 5. Generate Content (Lessons & Progress)
        // ==========================================
        $this->generateContentForTeacher($ustadimmah);
        $this->generateContentForTeacher($teacherA);
        $this->generateContentForTeacher($teacherB);

        $this->command->info("\n🎉 Seeder Completed!");
        $this->command->info("Login Ustadzah Himmah: 081216861835 / password");
    }

    private function generateContentForTeacher($teacher)
    {
        $classes = $teacher->getTeacherClasses();

        foreach ($classes as $class) {
            // Create 5 Lessons per class
            for ($i = 1; $i <= 5; $i++) {
                $lesson = Lesson::create([
                    'tahsin_class_id' => $class->id,
                    'title' => "Materi $i - " . $class->name,
                    'description' => "Deskripsi materi ke-$i",
                    'content' => "Isi detail materi pembelajaran ke-$i",
                    'created_by' => $teacher->id,
                    'order' => $i,
                ]);

                // Create Progress for students in this class
                $students = User::where('tahsin_class_id', $class->id)
                    ->where('role', 'student')
                    ->get();

                foreach ($students as $student) {
                    // 50% chance to complete
                    if (rand(0, 1)) {
                        UserProgress::create([
                            'user_id' => $student->id,
                            'lesson_id' => $lesson->id,
                            'is_completed' => true
                        ]);
                    }
                }
            }
        }
    }
}
