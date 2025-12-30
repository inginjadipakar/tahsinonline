<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subscription::with(['user', 'tahsinClass', 'assignedTeacher'])->latest();

        // Apply filters
        if ($request->tahsin_class_id) {
            $query->where('tahsin_class_id', $request->tahsin_class_id);
        }
        
        if ($request->filter === 'no_teacher') {
            $query->whereNull('assigned_teacher_id');
        } elseif ($request->filter === 'active') {
            $query->where('status', 'active');
        } elseif ($request->filter === 'pending') {
            $query->where('status', 'pending');
        }

        $subscriptions = $query->paginate(15)->withQueryString();
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();

        // Statistics for dashboard
        $totalSiswa = Subscription::distinct('user_id')->count();
        $activeCount = Subscription::where('status', 'active')->count();
        $pendingCount = Subscription::where('status', 'pending')->count();

        return view('admin.subscriptions.index', compact('subscriptions', 'teachers', 'totalSiswa', 'activeCount', 'pendingCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.subscriptions.create', compact('users', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tahsin_class_id' => 'nullable|exists:tahsin_classes,id',
            'assigned_teacher_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,pending',
        ]);

        Subscription::create($validated);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $users = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.subscriptions.edit', compact('subscription', 'users', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tahsin_class_id' => 'nullable|exists:tahsin_classes,id',
            'assigned_teacher_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,pending',
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->update($validated);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     * Also deletes the associated user account (cascade delete).
     */
    public function destroy(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $user = $subscription->user;
        
        if ($user) {
            $userName = $user->name;
            $userPhone = $user->phone;
            
            // Delete all user-related data
            DB::beginTransaction();
            try {
                // 1. Delete payments
                Payment::where('subscription_id', $subscription->id)->delete();
                Payment::where('user_id', $user->id)->delete();
                
                // 2. Delete user progress
                $user->userProgress()->delete();
                
                // 3. Delete all user's subscriptions
                $user->subscriptions()->delete();
                
                // 4. Delete user account
                $user->delete();
                
                DB::commit();
                
                return redirect()->route('admin.subscriptions.index')
                    ->with('success', "Subscription dan akun user '{$userName}' ({$userPhone}) berhasil dihapus PERMANEN. User harus daftar ulang untuk kembali.");
            } catch (\Exception $e) {
                DB::rollBack();
                
                return redirect()->route('admin.subscriptions.index')
                    ->with('error', 'Gagal menghapus subscription: ' . $e->getMessage());
            }
        } else {
            // Orphan subscription (no user)
            Payment::where('subscription_id', $subscription->id)->delete();
            $subscription->delete();
            
            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'Orphan subscription berhasil dihapus.');
        }
    }

    /**
     * Assign a teacher to a subscription.
     */
    public function assignTeacher(Request $request, Subscription $subscription)
    {
        $request->validate([
            'assigned_teacher_id' => 'required|exists:users,id',
        ]);

        $teacher = User::findOrFail($request->assigned_teacher_id);
        
        if ($teacher->role !== 'teacher') {
            return back()->with('error', 'User yang dipilih bukan guru.');
        }

        $subscription->update([
            'assigned_teacher_id' => $request->assigned_teacher_id,
        ]);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', "Guru {$teacher->name} berhasil di-assign ke siswa {$subscription->user->name}.");
    }

    /**
     * Remove teacher assignment from a subscription.
     */
    public function unassignTeacher(Subscription $subscription)
    {
        $teacherName = $subscription->assignedTeacher?->name ?? 'Guru';
        
        $subscription->update([
            'assigned_teacher_id' => null,
        ]);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', "{$teacherName} berhasil di-unassign dari siswa {$subscription->user->name}.");
    }

    /**
     * Get suggested teachers for a subscription (API).
     */
    public function suggestTeachers(Subscription $subscription)
    {
        $class = $subscription->tahsinClass;
        $student = $subscription->user;
        
        $query = User::where('role', 'teacher');

        // 1. Prioritize teachers who already teach this class
        if ($class) {
            $query->whereHas('assignedClasses', function ($q) use ($class) {
                $q->where('tahsin_class_id', $class->id);
            });
        }

        // 2. Filter by gender for private adult classes
        if ($class && str_contains(strtolower($class->name), 'privat') && $student && $student->age >= 12) {
            $query->where('gender', $student->gender);
        }

        // 3. Order by least students assigned
        $query->withCount([
            'teacherSubscriptions as current_students_count' => function ($q) {
                $q->whereIn('status', ['active', 'pending']);
            }
        ])->orderBy('current_students_count');

        return response()->json([
            'suggestions' => $query->take(5)->get(['id', 'name', 'gender']),
        ]);
    }
}
