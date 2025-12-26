<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\TahsinClass;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

echo "--- CREATING MISSING USER ---\n";

// 1. Find or Create Class
$className = 'Tahsin Privat (Dewasa)';
$class = TahsinClass::where('name', 'LIKE', "%$className%")->first();

if (!$class) {
    echo "Class '$className' not found. Using first available class or creating one.\n";
    $class = TahsinClass::first();
    if (!$class) {
        $class = TahsinClass::create([
            'name' => 'Tahsin Privat (Dewasa)',
            'level' => 'Dewasa',
            'type' => 'Privat', 
            'price' => 150000,
            'description' => 'Kelas privat untuk dewasa'
        ]);
        echo "Created new class.\n";
    }
}
echo "Assigning to Class ID: " . $class->id . " (" . $class->name . ")\n";

// 2. Create User
$userData = [
    'name' => 'R Ashiva Faranas',
    'phone' => '6281558402888', // Normalized format
    'password' => Hash::make('MJSmulia24#'),
    'role' => 'student',
    'tahsin_class_id' => $class->id,
    'is_child_account' => false,
    'email_verified_at' => Carbon::now(),
];

// Check if exists by phone to avoid duplicates (just in case)
$existing = User::where('phone', $userData['phone'])->first();
if ($existing) {
    echo "User with this phone already exists! Updating credentials...\n";
    $existing->update([
        'name' => $userData['name'],
        'password' => $userData['password'],
        'tahsin_class_id' => $userData['tahsin_class_id']
    ]);
    echo "User updated: ID " . $existing->id . "\n";
} else {
    $user = User::create($userData);
    echo "User created successfully: ID " . $user->id . "\n";
}

echo "Done.\n";
