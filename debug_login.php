<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Check DB Connection
echo "--- DB CONNECTION INFO ---\n";
$default = config('database.default');
echo "Default Connection: " . $default . "\n";
echo "Database: " . config("database.connections.$default.database") . "\n";
if ($default === 'sqlite') {
    echo "SQLite Path: " . config("database.connections.sqlite.database") . "\n";
} else {
    echo "Host: " . config("database.connections.$default.host") . "\n";
    echo "Port: " . config("database.connections.$default.port") . "\n";
}
exit;
// List ALL users

// List ALL users
echo "\n--- LISTING ALL USERS FROM DB ---\n";
$allParams = User::all();
foreach($allParams as $u) {
    echo "ID: " . $u->id . " | Name: " . $u->name . " | Phone: " . $u->phone . "\n";
}

echo "\n--- SEARCHING OTHER TABLES ---\n";
// Sometimes data exists in related tables but user is missing (orphan records)
try {
    $payments = \Illuminate\Support\Facades\DB::table('payments')->get();
    echo "Total Payments: " . $payments->count() . "\n";
    foreach($payments as $p) {
        echo "Payment ID: $p->id | User ID: $p->user_id | Status: $p->status\n";
    }
} catch (\Exception $e) { echo "Error reading payments: " . $e->getMessage() . "\n"; }

try {
    $subs = \Illuminate\Support\Facades\DB::table('subscriptions')->get();
    echo "Total Subscriptions: " . $subs->count() . "\n";
    foreach($subs as $s) {
        echo "Sub ID: $s->id | User ID: $s->user_id | Status: $s->status\n";
    }
} catch (\Exception $e) { echo "Error reading subscriptions: " . $e->getMessage() . "\n"; }

exit;

foreach ($users as $user) {
    echo "\nUser ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Stored Phone: " . $user->phone . "\n";
    echo "Role: " . $user->role . "\n";
    
    echo "--- Checking Password ---\n";
    if (Hash::check($passwordToCheck, $user->password)) {
        echo "[√] Password MATCHES.\n";
    } else {
        echo "[X] Password DOES NOT match.\n";
    }

    echo "--- Checking Phone Formats ---\n";
    if ($user->phone === $phoneInput) echo "Matches Input Phone ($phoneInput)\n";
    if ($user->phone === $phoneLegacy) echo "Matches Legacy Phone ($phoneLegacy)\n";
    if ($user->phone === $phoneNormalized) echo "Matches Normalized Phone ($phoneNormalized)\n";
    
    // Simulate LoginRequest Logic
    echo "--- Simulating Login Logic ---\n";
    
    // Test 1: Normalize Input
    $cleanInput = preg_replace('/[^0-9]/', '', $phoneInput);
    $normalizedInput = \App\Helpers\PhoneHelper::normalize($cleanInput);
    echo "Input Cleaned: $cleanInput\n";
    echo "Input Normalized: $normalizedInput\n";
    
    if ($normalizedInput === $user->phone) {
         echo "Logic Match: Normalized input matches stored phone.\n";
    } elseif ($cleanInput === $user->phone) {
         echo "Logic Match: Raw input matches stored phone (Legacy).\n";
    } else {
         echo "Logic Mismatch: Neither normalized nor raw input matches stored phone.\n";
    }
}
