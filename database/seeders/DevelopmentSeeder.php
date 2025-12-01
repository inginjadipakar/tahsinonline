<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TahsinClass;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds for development/testing
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Tahsinku',
            'email' => 'admin@tahsinku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Teacher Users
        $teacher1 = User::create([
            'name' => 'Ustadzah Himmah',
            'email' => 'himmah@tahsinku.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        $teacher2 = User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ahmad@tahsinku.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        // Create Student Users
        $student1 = User::create([
            'name' => 'Fatimah Zahra',
            'email' => 'fatimah@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $student2 = User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $student3 = User::create([
            'name' => 'Aisyah Nur',
            'email' => 'aisyah@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        // Get existing classes (assuming they exist from previous seeders)
        $classes = TahsinClass::all();

        if ($classes->count() > 0) {
            // Assign students to classes with subscriptions
            Subscription::create([
                'user_id' => $student1->id,
                'tahsin_class_id' => $classes->first()->id,
                'status' => 'active',
                'program_type' => 'tahsin',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]);

            Subscription::create([
                'user_id' => $student2->id,
                'tahsin_class_id' => $classes->first()->id,
                'status' => 'active',
                'program_type' => 'iqra',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]);

            Subscription::create([
                'user_id' => $student3->id,
                'tahsin_class_id' => $classes->skip(1)->first()?->id ?? $classes->first()->id,
                'status' => 'pending',
                'program_type' => 'tahsin',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]);
        }

        $this->command->info('✅ Development users created successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('==================');
        $this->command->info('Admin:    admin@tahsinku.com / password');
        $this->command->info('Teacher:  himmah@tahsinku.com / password');
        $this->command->info('Teacher:  ahmad@tahsinku.com / password');
        $this->command->info('Student:  fatimah@student.com / password');
        $this->command->info('Student:  ali@student.com / password');
        $this->command->info('Student:  aisyah@student.com / password');
    }
}
