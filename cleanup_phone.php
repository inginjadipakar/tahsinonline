<?php
/**
 * CLEANUP: Complete removal of user data by phone
 * Access: /cleanup-user/mjsmulia24/6281558402888
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

$phone = $_GET['phone'] ?? '6281558402888';

echo "=================================================================\n";
echo "COMPLETE CLEANUP FOR PHONE: {$phone}\n";
echo "=================================================================\n\n";

// Phone variants
$phoneVariants = [
    $phone,
    '0' . substr($phone, 2),
    '62' . ltrim($phone, '0'),
    '+' . $phone,
];

echo "🔍 Searching variants:\n";
foreach ($phoneVariants as $variant) {
    echo "   - {$variant}\n";
}
echo "\n";

DB::beginTransaction();
try {
    $deleted = [
        'users' => 0,
        'subscriptions' => 0,
        'payments' => 0,
        'user_progress' => 0,
    ];
    
    // 1. Find and delete USER
    foreach ($phoneVariants as $variant) {
        $users = User::where('phone', $variant)->get();
        foreach ($users as $user) {
            echo "🗑️  Deleting USER: {$user->name} (ID: {$user->id})\n";
            
            // Delete related data
            $user->userProgress()->delete();
            $deleted['user_progress'] += $user->userProgress()->count();
            
            $user->delete();
            $deleted['users']++;
        }
    }
    
    // 2. Find and delete ORPHAN SUBSCRIPTIONS
    $allSubs = Subscription::all();
    foreach ($allSubs as $sub) {
        $user = User::find($sub->user_id);
        if (!$user) {
            echo "🗑️  Deleting ORPHAN SUBSCRIPTION: ID {$sub->id}\n";
            
            // Delete payments first
            $payments = Payment::where('subscription_id', $sub->id)->get();
            foreach ($payments as $payment) {
                echo "   └─ Deleting payment: {$payment->amount}\n";
                $payment->delete();
                $deleted['payments']++;
            }
            
            $sub->delete();
            $deleted['subscriptions']++;
        }
    }
    
    DB::commit();
    
    echo "\n";
    echo "✅ CLEANUP COMPLETE!\n";
    echo "═══════════════════════════════════════════════════════════════\n";
    echo "Deleted:\n";
    echo "  - Users: {$deleted['users']}\n";
    echo "  - Subscriptions: {$deleted['subscriptions']}\n";
    echo "  - Payments: {$deleted['payments']}\n";
    echo "  - User Progress: {$deleted['user_progress']}\n";
    echo "\n";
    echo "✅ Phone {$phone} is now FREE to register again!\n";
    echo "═══════════════════════════════════════════════════════════════\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
}
