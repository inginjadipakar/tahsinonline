<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\TahsinClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // --- Statistik Peserta (Berbasis Subscription) ---
        // User requested: "jadikan subscription sebagai acuan"
        // Hanya menghitung siswa yang memiliki history subscription (user_id di tabel subscriptions)
        $studentQuery = User::where('role', 'student')->whereHas('subscriptions');

        $totalUsers = User::count();
        $totalStudents = $studentQuery->count(); // Matches SubscriptionController::distinct('user_id')
        $totalTeachers = User::where('role', 'teacher')->count();
        
        // Gender Distribution (Subscribed Students only)
        $studentGender = (clone $studentQuery)
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();
            
        // Age Distribution (Subscribed Students only)
        // Simple grouping: Anak (<12), Remaja (12-18), Dewasa (>18)
        $studentAge = (clone $studentQuery)
            ->get()
            ->groupBy(function($user) {
                if (!$user->age) return 'Tidak Diketahui';
                if ($user->age < 12) return 'Anak-anak (<12)';
                if ($user->age <= 18) return 'Remaja (12-18)';
                return 'Dewasa (>18)';
            })
            ->map->count();

        // --- Laporan Keuangan (Estimasi) ---
        // Revenue from Active Subscriptions
        $activeSubscriptions = Subscription::with('tahsinClass')
            ->where('status', 'active')
            ->get();
            
        $estimatedMonthlyRevenue = $activeSubscriptions->sum(function($sub) {
            return $sub->tahsinClass->price ?? 0;
        });
        
        // Revenue by Class Type
        $revenueByClass = $activeSubscriptions->groupBy('tahsin_class_id')
            ->map(function($subs) {
                $class = $subs->first()->tahsinClass;
                return [
                    'name' => $class->name ?? 'Unknown',
                    'count' => $subs->count(),
                    'revenue' => $subs->sum(fn($s) => $s->tahsinClass->price ?? 0),
                    'color' => $this->getClassColor($class->id ?? 0) 
                ];
            })->values();

        // Payment Statuses
        $pendingPayments = Payment::where('status', 'pending')->count();
        $verifiedPayments = Payment::where('status', 'verified')->count(); // Assuming 'verified' or similar

        return view('admin.reports.index', compact(
            'totalUsers', 'totalStudents', 'totalTeachers',
            'studentGender', 'studentAge',
            'estimatedMonthlyRevenue', 'revenueByClass',
            'pendingPayments', 'activeSubscriptions'
        ));
    }

    private function getClassColor($id) {
        $colors = ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6'];
        return $colors[$id % count($colors)];
    }
}
