<?php
/**
 * Check specific user by phone number
 * Access: https://tahsinonline-production.up.railway.app/check-user/mjsmulia24/6281558402888
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Subscription;
use App\Models\Payment;

// Get phone from URL parameter
$phone = $_GET['phone'] ?? '6281558402888';

echo "=================================================================\n";
echo "CHECKING USER: {$phone}\n";
echo "=================================================================\n\n";

// Try different phone formats
$phoneVariants = [
    $phone,
    '0' . substr($phone, 2), // 62xxx -> 08xxx
    '62' . substr($phone, 0), // add 62 if not present
    '+' . $phone,
];

echo "🔍 Searching with variants:\n";
foreach ($phoneVariants as $variant) {
    echo "   - {$variant}\n";
}
echo "\n";

$foundUser = null;
foreach ($phoneVariants as $variant) {
    $user = User::where('phone', $variant)->first();
    if ($user) {
        $foundUser = $user;
        echo "✅ USER FOUND with phone: {$variant}\n\n";
        break;
    }
}

if (!$foundUser) {
    echo "❌ USER NOT FOUND in database!\n\n";
    
    // Check for orphan subscription
    echo "🔍 Checking for orphan subscriptions...\n";
    $allSubscriptions = Subscription::with('user')->get();
    
    foreach ($allSubscriptions as $sub) {
        if (!$sub->user) {
            echo "⚠️  Found orphan subscription #{$sub->id}\n";
            $payment = Payment::where('subscription_id', $sub->id)->first();
            if ($payment) {
                echo "   Payment exists: {$payment->amount}\n";
            }
        }
    }
    
    echo "\n";
    echo "🔴 DIAGNOSIS: ORPHAN SUBSCRIPTION\n";
    echo "   User registered → Subscription created\n";
    echo "   But user account was not created (BUG)\n";
    echo "   SOLUTION: Run recovery script\n";
    exit;
}

// User exists - show details
echo "USER DETAILS:\n";
echo "─────────────────────────────────────────────────────────────────\n";
echo "ID: {$foundUser->id}\n";
echo "Name: {$foundUser->name}\n";
echo "Phone: {$foundUser->phone}\n";
echo "Email: {$foundUser->email}\n";
echo "Role: {$foundUser->role}\n";
echo "Created: {$foundUser->created_at}\n";
echo "\n";

// Check subscription
$subscription = Subscription::where('user_id', $foundUser->id)->first();
if ($subscription) {
    echo "SUBSCRIPTION:\n";
    echo "─────────────────────────────────────────────────────────────────\n";
    echo "Status: {$subscription->status}\n";
    echo "Class ID: {$subscription->tahsin_class_id}\n";
    echo "Start: {$subscription->start_date}\n";
    echo "End: {$subscription->end_date}\n";
    echo "\n";
}

// Check payment
$payment = $subscription ? Payment::where('subscription_id', $subscription->id)->first() : null;
if ($payment) {
    echo "PAYMENT:\n";
    echo "─────────────────────────────────────────────────────────────────\n";
    echo "Amount: {$payment->amount}\n";
    echo "Method: {$payment->payment_method}\n";
    echo "Proof: " . ($payment->payment_proof ? "✅ ADA" : "❌ TIDAK ADA") . "\n";
    echo "\n";
}

// Password check
echo "PASSWORD:\n";
echo "─────────────────────────────────────────────────────────────────\n";
echo "Hash exists: " . (!empty($foundUser->password) ? "✅ YES" : "❌ NO") . "\n";
echo "Hash preview: " . substr($foundUser->password, 0, 20) . "...\n";
echo "\n";

// Login test
echo "LOGIN TEST:\n";
echo "─────────────────────────────────────────────────────────────────\n";
echo "To test login, try these phone formats:\n";
echo "1. {$foundUser->phone} (exact match)\n";
echo "2. 0" . substr($foundUser->phone, 2) . " (08xxx format)\n";
echo "3. +{$foundUser->phone} (with +)\n";
echo "\n";

if (empty($foundUser->password)) {
    echo "🔴 PROBLEM: Password hash is EMPTY!\n";
    echo "   User cannot login because password not set.\n";
    echo "   SOLUTION: Reset password\n";
} else {
    echo "✅ Password hash exists - check if password is correct\n";
}

echo "\n=================================================================\n";
