<?php
/**
 * RECOVERY SCRIPT: Recreate Missing Users from Orphan Subscriptions
 * 
 * CRITICAL: Script ini akan membuat user baru untuk orphan subscriptions
 * 
 * Jalankan via web (production):
 * https://tahsinonline-production.up.railway.app/recover-orphans/mjsmulia24
 * 
 * CARA PAKAI:
 * 1. User yang bermasalah harus contact admin
 * 2. Admin tanya: Nama, No HP, Password yang diinginkan
 * 3. Admin isi data di script ini
 * 4. Run script
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Subscription;
use App\Models\User;
use App\Models\Payment;
use App\Helpers\PhoneHelper;

echo "=" . str_repeat("=", 70) . "\n";
echo "RECOVERY: RECREATE MISSING USERS\n";
echo "=" . str_repeat("=", 70) . "\n\n";

// Find orphan subscriptions
$orphanSubscriptions = [];
$allSubscriptions = Subscription::all();

foreach ($allSubscriptions as $subscription) {
    $user = User::find($subscription->user_id);
    if (!$user) {
        $orphanSubscriptions[] = $subscription;
    }
}

if (count($orphanSubscriptions) === 0) {
    echo "✅ No orphan subscriptions found. All good!\n";
    exit;
}

echo "Found " . count($orphanSubscriptions) . " orphan subscription(s)\n\n";

// MANUAL DATA INPUT - Admin harus isi ini
// Format: subscription_id => ['name' => '...', 'phone' => '...', 'password' => '...']
$recoveryData = [
    // Example (ganti dengan data real):
    // 123 => [
    //     'name' => 'Nama Peserta',
    //     'phone' => '081234567890', // Format apapun OK, akan dinormalisasi
    //     'password' => 'password123', // Password yang diinginkan user
    //     'gender' => 'male', // or 'female'
    //     'address' => 'Alamat',
    //     'occupation' => 'Pekerjaan',
    //     'age' => 25,
    // ],
];

echo "📋 Recovery Data Configured: " . count($recoveryData) . " user(s)\n\n";

if (count($recoveryData) === 0) {
    echo "⚠️  WARNING: No recovery data configured!\n";
    echo "   Please fill \$recoveryData array in this script.\n\n";
    
    echo "   TEMPLATE untuk admin:\n\n";
    foreach ($orphanSubscriptions as $orphan) {
        $payment = Payment::where('subscription_id', $orphan->id)->first();
        echo "   // Subscription #{$orphan->id}\n";
        echo "   {$orphan->id} => [\n";
        echo "       'name' => 'NAMA_PESERTA',\n";
        echo "       'phone' => 'NO_HP_PESERTA',\n";
        echo "       'password' => 'PASSWORD_BARU',\n";
        echo "       'gender' => 'male', // or 'female'\n";
        echo "       'address' => 'ALAMAT',\n";
        echo "       'occupation' => 'PEKERJAAN',\n";
        echo "       'age' => 25,\n";
        echo "   ],\n\n";
    }
    exit;
}

// Process recovery
$recovered = 0;
$failed = 0;

foreach ($recoveryData as $subscriptionId => $userData) {
    $subscription = Subscription::find($subscriptionId);
    
    if (!$subscription) {
        echo "❌ Subscription #{$subscriptionId} not found\n";
        $failed++;
        continue;
    }
    
    try {
        // Normalize phone
        $normalizedPhone = PhoneHelper::normalize($userData['phone']);
        
        // Create user with EXACT user_id from subscription
        $user = User::create([
            'id' => $subscription->user_id, // PENTING: pakai ID yang sama!
            'name' => $userData['name'],
            'phone' => $normalizedPhone,
            'password' => bcrypt($userData['password']),
            'role' => 'student',
            'tahsin_class_id' => $subscription->tahsin_class_id,
            'gender' => $userData['gender'] ?? 'male',
            'address' => $userData['address'] ?? '',
            'occupation' => $userData['occupation'] ?? '',
            'age' => $userData['age'] ?? null,
            'is_child_account' => false,
        ]);
        
        echo "✅ RECOVERED: {$user->name} (Phone: {$user->phone})\n";
        echo "   User ID: {$user->id}\n";
        echo "   Subscription ID: {$subscription->id}\n";
        echo "   Can now login with: {$normalizedPhone}\n\n";
        
        $recovered++;
    } catch (\Exception $e) {
        echo "❌ FAILED: Subscription #{$subscriptionId}\n";
        echo "   Error: " . $e->getMessage() . "\n\n";
        $failed++;
    }
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "RECOVERY COMPLETE\n";
echo "Recovered: {$recovered}\n";
echo "Failed: {$failed}\n";
echo "=" . str_repeat("=", 70) . "\n";
