<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    $classes = \App\Models\TahsinClass::where('is_active', true)->orderBy('order')->get();
    return view('welcome', compact('classes'));
});

// Debug route to check prices
Route::get('/debug-prices', function () {
    $classes = \App\Models\TahsinClass::where('is_active', true)->orderBy('order')->get();
    return response()->json($classes);
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

require __DIR__.'/auth.php';
