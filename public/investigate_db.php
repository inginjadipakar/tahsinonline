<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

echo "=== RAILWAY PRODUCTION DATABASE INVESTIGATION ===\n\n";

// 1. Check all users
echo "--- ALL USERS IN DATABASE ---\n";
$users = User::all();
echo "Total Users: " . $users->count() . "\n";
foreach($users as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | Phone: {$u->phone} | Role: {$u->role}\n";
}

// 2. Search for Ashiva in users
echo "\n--- SEARCHING FOR 'ASHIVA' IN USERS ---\n";
$ashiva = User::where('name', 'LIKE', '%Ashiva%')
    ->orWhere('phone', 'LIKE', '%81558402888%')
    ->get();
if ($ashiva->isEmpty()) {
    echo "❌ NOT FOUND in users table\n";
} else {
    foreach($ashiva as $u) {
        echo "✅ FOUND: ID {$u->id} | {$u->name} | {$u->phone}\n";
    }
}

// 3. Check subscriptions for Ashiva
echo "\n--- SUBSCRIPTIONS FOR 'ASHIVA' ---\n";
$subs = Subscription::with('user')->get();
echo "Total Subscriptions: " . $subs->count() . "\n";
foreach($subs as $s) {
    $userName = $s->user ? $s->user->name : 'USER NOT FOUND';
    echo "Sub ID: {$s->id} | User ID: {$s->user_id} | Name: {$userName} | Status: {$s->status}\n";
    if (stripos($userName, 'Ashiva') !== false) {
        echo "  >>> THIS IS ASHIVA'S SUBSCRIPTION <<<\n";
        echo "  User ID references: {$s->user_id}\n";
        echo "  Checking if user exists...\n";
        $userExists = User::find($s->user_id);
        if (!$userExists) {
            echo "  ❌ CRITICAL: User ID {$s->user_id} DOES NOT EXIST in users table!\n";
            echo "  This is an ORPHAN subscription (subscription without user account)\n";
        }
    }
}

// 4. Check payments for Ashiva
echo "\n--- PAYMENTS ---\n";
$payments = Payment::with('user')->get();
foreach($payments as $p) {
    $userName = $p->user ? $p->user->name : 'USER NOT FOUND';
    if (stripos($userName, 'Ashiva') !== false || $p->user_id == null) {
        echo "Payment ID: {$p->id} | User ID: {$p->user_id} | Name: {$userName} | Status: {$p->status}\n";
    }
}

// 5. Find orphan records
echo "\n--- ORPHAN RECORDS ANALYSIS ---\n";
$orphanSubs = Subscription::whereNotIn('user_id', User::pluck('id'))->get();
echo "Orphan Subscriptions (no matching user): " . $orphanSubs->count() . "\n";
foreach($orphanSubs as $s) {
    echo "  Sub ID: {$s->id} | Missing User ID: {$s->user_id}\n";
}

echo "\n=== END OF INVESTIGATION ===\n";
