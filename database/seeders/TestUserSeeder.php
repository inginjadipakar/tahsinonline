<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TahsinClass;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Create test users for debugging login issues
     */
    public function run(): void
    {
        // Get first active class
        $class = TahsinClass::where('is_active', true)->first();
        
        if (!$class) {
            $this->command->error('No active class found! Please create a class first.');
            return;
        }

        // Test User 1: Standard format
        $user1 = User::create([
            'name' => 'Test User Login',
            'phone' => '6281234567890', // Normalized format
            'password' => Hash::make('TestPassword123!'),
            'role' => 'student',
            'gender' => 'male',
            'age' => 25,
            'address' => 'Jakarta',
            'occupation' => 'Testing',
        ]);

        Subscription::create([
            'user_id' => $user1->id,
            'tahsin_class_id' => $class->id,
            'status' => 'active',
            'program_type' => 'regular',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);

        $this->command->info('✅ Test user created!');
        $this->command->info('Phone: 81234567890 (or 081234567890 or 6281234567890)');
        $this->command->info('Password: TestPassword123!');
    }
}
