<?php
/**
 * CRITICAL: Diagnostic Script untuk Orphan Subscriptions
 * 
 * Jalankan di Railway:
 * railway run php diagnose_orphans.php
 * 
 * Atau akses via web (production):
 * https://tahsinonline-production.up.railway.app/diagnose-orphans/mjsmulia24
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Subscription;
use App\Models\User;
use App\Models\Payment;

echo "=" . str_repeat("=", 70) . "\n";
echo "DIAGNOSTIC: ORPHAN SUBSCRIPTIONS & MISSING USERS\n";
echo "=" . str_repeat("=", 70) . "\n\n";

// 1. Cari Orphan Subscriptions (subscription tanpa user)
echo "🔍 Checking for ORPHAN SUBSCRIPTIONS...\n\n";

$allSubscriptions = Subscription::all();
$orphanSubscriptions = [];
$validSubscriptions = 0;

foreach ($allSubscriptions as $subscription) {
    $user = User::find($subscription->user_id);
    
    if (!$user) {
        $orphanSubscriptions[] = $subscription;
        echo "❌ ORPHAN FOUND!\n";
        echo "   Subscription ID: {$subscription->id}\n";
        echo "   User ID: {$subscription->user_id} (USER TIDAK EXIST!)\n";
        echo "   Tahsin Class ID: {$subscription->tahsin_class_id}\n";
        echo "   Status: {$subscription->status}\n";
        echo "   Created: {$subscription->created_at}\n";
        
        // Check payment
        $payment = Payment::where('subscription_id', $subscription->id)->first();
        if ($payment) {
            echo "   💰 Payment: {$payment->amount} - {$payment->payment_method}\n";
            echo "   📸 Proof: " . ($payment->payment_proof ? "ADA" : "TIDAK ADA") . "\n";
        }
        echo "\n";
    } else {
        $validSubscriptions++;
    }
}

echo "\n" . str_repeat("-", 70) . "\n";
echo "SUMMARY:\n";
echo "Total Subscriptions: " . $allSubscriptions->count() . "\n";
echo "Valid Subscriptions: {$validSubscriptions}\n";
echo "Orphan Subscriptions: " . count($orphanSubscriptions) . "\n";
echo str_repeat("-", 70) . "\n\n";

// 2. Cari Users dengan Phone Number Issues
echo "🔍 Checking for PHONE NUMBER MISMATCHES...\n\n";

$users = User::where('role', 'student')->get();
$phoneIssues = [];

foreach ($users as $user) {
    // Check if phone starts with 08 (legacy format)
    if (substr($user->phone, 0, 2) === '08') {
        $phoneIssues[] = $user;
        echo "⚠️  LEGACY PHONE FORMAT:\n";
        echo "   User: {$user->name}\n";
        echo "   Phone: {$user->phone} (Should be 628...)\n";
        echo "   Email: {$user->email}\n\n";
    }
}

echo "\n" . str_repeat("-", 70) . "\n";
echo "Legacy Phone Formats Found: " . count($phoneIssues) . "\n";
echo str_repeat("-", 70) . "\n\n";

// 3. Recommendation
echo "📋 RECOMMENDATIONS:\n\n";

if (count($orphanSubscriptions) > 0) {
    echo "🔴 CRITICAL: " . count($orphanSubscriptions) . " orphan subscription(s) found!\n";
    echo "   Action needed: Run recovery script to recreate missing users\n\n";
    
    echo "   📝 Affected users data:\n";
    foreach ($orphanSubscriptions as $orphan) {
        $payment = Payment::where('subscription_id', $orphan->id)->first();
        echo "   - Subscription #{$orphan->id}, Payment: " . ($payment ? "✅" : "❌") . "\n";
    }
    echo "\n";
}

if (count($phoneIssues) > 0) {
    echo "⚠️  WARNING: " . count($phoneIssues) . " user(s) with legacy phone format\n";
    echo "   These might have login issues\n";
    echo "   Auto-migration in LoginRequest should handle this\n\n";
}

if (count($orphanSubscriptions) === 0 && count($phoneIssues) === 0) {
    echo "✅ ALL CLEAR! No issues found.\n\n";
}

echo "=" . str_repeat("=", 70) . "\n";
echo "DIAGNOSIS COMPLETE\n";
echo "=" . str_repeat("=", 70) . "\n";
