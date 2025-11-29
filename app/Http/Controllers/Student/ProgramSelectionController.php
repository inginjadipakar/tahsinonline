<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramSelectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'program_type' => 'required|in:iqra,tahsin',
        ]);

        $user = Auth::user();
        $subscription = $user->subscription;

        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki langganan aktif.');
        }

        // Update subscription with selected program
        $subscription->update([
            'program_type' => $request->program_type
        ]);

        // Prepare WhatsApp Message
        $adminNumber = '6282230466573'; // Admin WhatsApp Number
        $name = $user->name;
        $program = ucfirst($request->program_type);
        
        // Determine package name based on duration (simplified logic, can be enhanced)
        $startDate = \Carbon\Carbon::parse($subscription->start_date);
        $endDate = \Carbon\Carbon::parse($subscription->end_date);
        $diffInMonths = $startDate->diffInMonths($endDate);
        
        $packageName = 'Tahsin Online'; // Default
        if ($diffInMonths >= 12) $packageName = 'Tahunan';
        elseif ($diffInMonths >= 6) $packageName = 'Semester';
        elseif ($diffInMonths >= 1) $packageName = 'Bulanan';

        $message = "Assalamu'alaikum Admin, saya {$name}. Saya sudah berlangganan paket {$packageName} dan memilih program *{$program}*. Mohon bimbingannya untuk tes penempatan.";
        
        $encodedMessage = urlencode($message);
        $whatsappUrl = "https://wa.me/{$adminNumber}?text={$encodedMessage}";

        // Redirect to WhatsApp
        return redirect()->away($whatsappUrl);
    }
}
