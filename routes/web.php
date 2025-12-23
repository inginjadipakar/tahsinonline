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

// SECRET: Seed user accounts untuk production
// Akses: /seed-users/mjsmulia24
Route::get('/seed-users/{secret}', function ($secret) {
    // Validate secret key
    if ($secret !== 'mjsmulia24') {
        abort(404);
    }

    // Get Tahsin Dewasa class
    $tahsinDewasa = DB::table('tahsin_classes')->where('name', 'like', '%Reguler%Dewasa%')->first();

    // Delete existing users first (safe way)
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Create Admin
    DB::table('users')->insert([
        'name' => 'Admin Utama',
        'phone' => '6282230466573',
        'password' => bcrypt('mjsmulia24'),
        'role' => 'admin',
        'gender' => 'male',
        'address' => 'Kantor Admin',
        'occupation' => 'Administrator',
        'age' => 30,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Create Student
    DB::table('users')->insert([
        'name' => 'Siswa Baru',
        'phone' => '628813224569',
        'password' => bcrypt('mjsmulia24'),
        'role' => 'student',
        'tahsin_class_id' => $tahsinDewasa ? $tahsinDewasa->id : 1,
        'gender' => 'male',
        'address' => 'Surabaya',
        'occupation' => 'Pegawai Swasta',
        'age' => 25,
        'is_child_account' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Create Teacher
    DB::table('users')->insert([
        'name' => 'Ustadz Pengajar',
        'phone' => '6281216861835',
        'password' => bcrypt('mjsmulia24'),
        'role' => 'teacher',
        'gender' => 'male',
        'address' => 'Rumah Guru',
        'occupation' => 'Pengajar Al-Quran',
        'age' => 35,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json([
        'status' => 'success',
        'message' => '3 akun berhasil dibuat!',
        'users' => [
            ['role' => 'admin', 'phone' => '6282230466573', 'password' => 'mjsmulia24'],
            ['role' => 'student', 'phone' => '628813224569', 'password' => 'mjsmulia24'],
            ['role' => 'teacher', 'phone' => '6281216861835', 'password' => 'mjsmulia24'],
        ]
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

require __DIR__ . '/auth.php';
