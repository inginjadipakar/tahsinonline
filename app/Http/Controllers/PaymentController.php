<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admin: View all payments
        if (auth()->user()->role === 'admin') {
            $payments = \App\Models\Payment::with('user')->latest()->paginate(10);
            return view('admin.payments.index', compact('payments'));
        }
        
        // Student: View own payments
        $payments = auth()->user()->payments()->latest()->paginate(10);
        return view('student.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $subscription = $user->subscription()->where('status', 'pending')->with('tahsinClass')->first();
        
        $amount = 0;
        $packageName = 'Paket Belajar';

        if ($subscription && $subscription->tahsinClass) {
            $basePrice = $subscription->tahsinClass->price;
            $durationInMonths = $subscription->start_date->diffInMonths($subscription->end_date);
            
            // Round to nearest standard duration
            if ($durationInMonths >= 11) {
                $amount = $basePrice * 12 * 0.75;
                $packageName = 'Paket Tahunan';
            } elseif ($durationInMonths >= 5) {
                $amount = $basePrice * 6 * 0.85;
                $packageName = 'Paket Semester';
            } else {
                $amount = $basePrice;
                $packageName = 'Paket Bulanan';
            }
        }

        return view('student.payments.create', compact('subscription', 'amount', 'packageName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        \App\Models\Payment::create([
            'user_id' => auth()->id(),
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment proof uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $payment = \App\Models\Payment::findOrFail($id);
        $payment->update(['status' => $request->status]);

        // If accepted, create or update subscription
        if ($request->status === 'accepted') {
            \App\Models\Subscription::updateOrCreate(
                ['user_id' => $payment->user_id],
                [
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addDays(28),
                ]
            );
        }

        return redirect()->back()->with('success', 'Payment status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
