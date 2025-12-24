<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('dashboard');
    }
    $classes = \App\Models\TahsinClass::where('is_active', true)->orderBy('order')->get();
    return view('welcome', compact('classes'));
});

// Seed tahsin classes ke production database
Route::get('/seed-tahsin-classes', function () {
    // Cek apakah sudah ada data
    $existing = DB::table('tahsin_classes')->count();

    if ($existing > 0) {
        return response()->json([
            'status' => 'already_seeded',
            'message' => 'Data sudah ada di database',
            'total' => $existing
        ]);
    }

    // Insert data dengan harga baru
    DB::table('tahsin_classes')->insert([
        [
            'name' => 'Tahsin Anak Reguler',
            'description' => 'Kelas tahsin untuk anak-anak dengan sistem reguler (3-6 peserta). Belajar membaca Al-Quran dengan benar sesuai kaidah tajwid dalam suasana yang menyenangkan.',
            'price' => 150000,
            'order' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Tahsin Anak Privat',
            'description' => 'Kelas tahsin privat khusus untuk anak-anak dengan pendampingan personal one-on-one. Pembelajaran intensif dan fokus sesuai kemampuan anak.',
            'price' => 350000,
            'order' => 2,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Tahsin Reguler (Dewasa)',
            'description' => 'Kelas tahsin untuk umum/dewasa dengan sistem reguler. Memperbaiki bacaan Al-Quran sesuai dengan kaidah tajwid yang benar.',
            'price' => 120000,
            'order' => 3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Tahsin Privat (Dewasa)',
            'description' => 'Kelas tahsin privat untuk dewasa dengan metode pembelajaran personal. Jadwal fleksibel dan materi disesuaikan dengan kebutuhan.',
            'price' => 300000,
            'order' => 4,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    return response()->json([
        'status' => 'success',
        'message' => '4 paket tahsin berhasil ditambahkan!',
        'data' => DB::table('tahsin_classes')->orderBy('order')->get()
    ]);
});

// SECRET: Seed user accounts untuk production (SAFE - tidak menghapus user lain)
// Akses: /seed-users/mjsmulia24
Route::get('/seed-users/{secret}', function ($secret) {
    // Validate secret key
    if ($secret !== 'mjsmulia24') {
        abort(404);
    }

    // Get Tahsin Dewasa class
    $tahsinDewasa = DB::table('tahsin_classes')->where('name', 'like', '%Reguler%Dewasa%')->first();

    $results = [];

    // Create or Update Admin (tidak menghapus user lain)
    $admin = \App\Models\User::updateOrCreate(
        ['phone' => '6282230466573'], // Find by phone
        [
            'name' => 'Admin Utama',
            'password' => bcrypt('mjsmulia24'),
            'role' => 'admin',
            'gender' => 'male',
            'address' => 'Kantor Admin',
            'occupation' => 'Administrator',
            'age' => 30,
        ]
    );
    $results[] = ['role' => 'admin', 'phone' => '6282230466573', 'status' => $admin->wasRecentlyCreated ? 'created' : 'updated'];

    // Create or Update Student
    $student = \App\Models\User::updateOrCreate(
        ['phone' => '628813224569'],
        [
            'name' => 'Siswa Baru',
            'password' => bcrypt('mjsmulia24'),
            'role' => 'student',
            'tahsin_class_id' => $tahsinDewasa ? $tahsinDewasa->id : 1,
            'gender' => 'male',
            'address' => 'Surabaya',
            'occupation' => 'Pegawai Swasta',
            'age' => 25,
            'is_child_account' => false,
        ]
    );
    $results[] = ['role' => 'student', 'phone' => '628813224569', 'status' => $student->wasRecentlyCreated ? 'created' : 'updated'];

    // Create or Update Teacher
    $teacher = \App\Models\User::updateOrCreate(
        ['phone' => '6281216861835'],
        [
            'name' => 'Ustadz Pengajar',
            'password' => bcrypt('mjsmulia24'),
            'role' => 'teacher',
            'gender' => 'male',
            'address' => 'Rumah Guru',
            'occupation' => 'Pengajar Al-Quran',
            'age' => 35,
        ]
    );
    $results[] = ['role' => 'teacher', 'phone' => '6281216861835', 'status' => $teacher->wasRecentlyCreated ? 'created' : 'updated'];

    // Count total users
    $totalUsers = \App\Models\User::count();

    return response()->json([
        'status' => 'success',
        'message' => '3 akun default berhasil dibuat/diupdate! User lain TIDAK dihapus.',
        'total_users_in_db' => $totalUsers,
        'default_accounts' => $results
    ]);
});

// SECRET: Delete user by phone (for admin cleanup)
// Akses: /delete-user/mjsmulia24/6281558402888
Route::get('/delete-user/{secret}/{phone}', function ($secret, $phone) {
    if ($secret !== 'mjsmulia24') {
        abort(404);
    }

    $user = \App\Models\User::where('phone', $phone)->first();
    
    if (!$user) {
        return response()->json([
            'status' => 'not_found',
            'message' => "User dengan phone {$phone} tidak ditemukan."
        ]);
    }

    $userName = $user->name;
    
    // Delete related records
    $user->subscription()->delete();
    \App\Models\Payment::where('user_id', $user->id)->delete();
    $user->delete();

    return response()->json([
        'status' => 'success',
        'message' => "User '{$userName}' dengan phone {$phone} berhasil dihapus!"
    ]);
});

// SECRET: Cleanup subscriptions for non-students (admin/teacher)
// Akses: /cleanup-subscriptions/mjsmulia24
Route::get('/cleanup-subscriptions/{secret}', function ($secret) {
    if ($secret !== 'mjsmulia24') {
        abort(404);
    }

    // Delete subscriptions where user is not a student
    $deleted = \App\Models\Subscription::whereHas('user', function($q) {
        $q->where('role', '!=', 'student');
    })->delete();

    return response()->json([
        'status' => 'success',
        'message' => "Deleted {$deleted} subscription(s) belonging to non-student users."
    ]);
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Student\SubscriptionController as StudentSubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AdminOnly;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Subscription
    Route::get('/subscription', [StudentSubscriptionController::class, 'index'])->name('student.subscription.index');

    // Program Selection
    Route::post('/program-selection', [\App\Http\Controllers\Student\ProgramSelectionController::class, 'store'])->name('student.program-selection.store');

    // My Class (Kelas Saya)
    Route::get('/my-class', [\App\Http\Controllers\Student\MyClassController::class, 'index'])->name('student.my-class');

    // Payments (Shared Access)
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

    // Student Tahsin Classes
    Route::get('/classes', [\App\Http\Controllers\Student\TahsinClassController::class, 'index'])->name('student.classes.index');
    Route::get('/classes/{tahsinClass}', [\App\Http\Controllers\Student\TahsinClassController::class, 'show'])->name('student.classes.show');
    Route::get('/lessons/{lesson}', [\App\Http\Controllers\Student\TahsinClassController::class, 'showLesson'])->name('student.lessons.show');
    Route::post('/lessons/{lesson}/complete', [\App\Http\Controllers\Student\TahsinClassController::class, 'markComplete'])->name('student.lessons.complete');

    // Infak
    Route::get('/infak', [\App\Http\Controllers\Student\InfakController::class, 'index'])->name('student.infak.index');

    // Menu (Mobile)
    Route::get('/menu', [\App\Http\Controllers\Student\MenuController::class, 'index'])->name('student.menu.index');
});

// Admin Routes
Route::middleware(['auth', AdminOnly::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('subscriptions', AdminSubscriptionController::class);
    
    // Teacher Assignment for Subscriptions
    Route::patch('subscriptions/{subscription}/assign-teacher', [AdminSubscriptionController::class, 'assignTeacher'])->name('subscriptions.assign-teacher');
    Route::delete('subscriptions/{subscription}/unassign-teacher', [AdminSubscriptionController::class, 'unassignTeacher'])->name('subscriptions.unassign-teacher');
    Route::get('subscriptions/{subscription}/suggest-teachers', [AdminSubscriptionController::class, 'suggestTeachers'])->name('subscriptions.suggest-teachers');
    
    Route::resource('tahsin-classes', \App\Http\Controllers\Admin\TahsinClassController::class);
    Route::resource('lessons', \App\Http\Controllers\Admin\LessonController::class);

    // Class Schedule Management
    Route::resource('schedules', \App\Http\Controllers\Admin\ClassScheduleController::class);
    Route::post('schedules/{schedule}/activate', [\App\Http\Controllers\Admin\ClassScheduleController::class, 'activate'])->name('schedules.activate');
    Route::post('schedules/{schedule}/deactivate', [\App\Http\Controllers\Admin\ClassScheduleController::class, 'deactivate'])->name('schedules.deactivate');
    Route::post('schedules/copy-last/{tahsinClass}', [\App\Http\Controllers\Admin\ClassScheduleController::class, 'copyLast'])->name('schedules.copy-last');
});

// Admin Payment Actions
Route::middleware(['auth', AdminOnly::class])->group(function () {
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
});

// Guest Program Selection
Route::get('select-program', function (\Illuminate\Http\Request $request) {
    $class = null;
    if ($request->has('class_id')) {
        $class = \App\Models\TahsinClass::find($request->class_id);
    }
    return view('auth.select-program', compact('class'));
})->name('guest.select-program');

// Teacher Routes
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;
use App\Http\Controllers\Teacher\StudentProgressController as TeacherStudentProgressController;
use App\Http\Middleware\TeacherOnly;

Route::middleware(['auth', TeacherOnly::class])->prefix('teacher')->name('teacher.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::post('/switch-class', [TeacherDashboardController::class, 'switchClass'])->name('switch-class');

    // Lesson Management
    Route::resource('lessons', TeacherLessonController::class);
    Route::get('lessons/{lesson}/download', [TeacherLessonController::class, 'download'])->name('lessons.download');

    // Student Progress
    Route::get('/students', [TeacherStudentProgressController::class, 'index'])->name('students.index');
    Route::get('/students/{student}/progress', [TeacherStudentProgressController::class, 'show'])->name('students.show');
});

// Storage file serving for Railway (fallback when storage:link doesn't work)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($fullPath);
    
    return response()->file($fullPath, [
        'Content-Type' => $mimeType,
    ]);
})->where('path', '.*');

require __DIR__ . '/auth.php';
