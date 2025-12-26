# 🚀 Deployment & Integration Guide

## CRITICAL: Railway Production Setup

### 1. Run Migrations (WAJIB!)
```bash
# SSH ke Railway atau gunakan Railway CLI
railway run php artisan migrate

# Atau jika ada error, run satu per satu:
railway run php artisan migrate --path=/database/migrations/2025_12_26_053029_add_media_fields_to_lessons_table.php
railway run php artisan migrate --path=/database/migrations/2025_12_26_054649_create_lesson_comments_table.php
railway run php artisan migrate --path=/database/migrations/2025_12_26_055020_create_quizzes_table.php
railway run php artisan migrate --path=/database/migrations/2025_12_26_055040_create_quiz_questions_table.php
railway run php artisan migrate --path=/database/migrations/2025_12_26_055107_create_quiz_options_table.php
railway run php artisan migrate --path=/database/migrations/2025_12_26_055126_create_quiz_attempts_table.php
```

### 2. Link Storage (WAJIB untuk PDF!)
```bash
railway run php artisan storage:link
```

### 3. Clear Cache
```bash
railway run php artisan cache:clear
railway run php artisan config:clear
railway run php artisan route:clear
railway run php artisan view:clear
```

---

## ✅ Fixed Issues

### 1. ✅ Lesson Model - Quiz Relationship
**File**: `app/Models/Lesson.php`
- Added `quiz()` relationship 
- Enhanced `getEmbedUrl()` with warning logs for invalid URLs
- Added `hasValidVideo()` helper method

**Usage**:
```php
// Check if lesson has quiz
if ($lesson->quiz) {
    echo "Quiz available!";
}

// Get quiz
$quiz = $lesson->quiz;
```

### 2. ✅ Video URL Validation Enhanced
Now logs invalid URLs to help debugging:
```php
// In Laravel logs (storage/logs/laravel.log):
// "Invalid YouTube URL format: https://example.com for lesson ID 5"
```

### 3. ⚠️ Integration Pending (Need Manual Work)

Since lesson show views don't exist yet, here's how to integrate when you create them:

#### Create Student Lesson Show Controller & View

**Controller** (`app/Http/Controllers/Student/LessonController.php`):
```php
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        // Load relationships
        $lesson->load(['quiz', 'comments.user', 'comments.replies.user']);
        
        return view('student.lessons.show', compact('lesson'));
    }
}
```

**Route** (add to `routes/web.php`):
```php
// Student routes
Route::middleware(['auth', 'role:student'])->prefix('lessons')->name('lessons.')->group(function () {
    Route::get('/{lesson}', [App\Http\Controllers\Student\LessonController::class, 'show'])->name('show');
});
```

**View** (`resources/views/student/lessons/show.blade.php`):
```blade
<x-app-layout>
    <div class="py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">{{ $lesson->title }}</h1>
        
        <!-- Video Player -->
        <x-lesson.video-player :lesson="$lesson" />
        
        <!-- PDF Viewer -->
        <x-lesson.pdf-viewer :lesson="$lesson" />
        
        <!-- Lesson Content -->
        <div class="bg-white rounded-lg p-6 mb-6">
            <div class="prose max-w-none">
                {!! nl2br(e($lesson->content)) !!}
            </div>
        </div>
        
        <!-- Quiz Link (if exists) -->
        @if($lesson->quiz)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold mb-2">📝 Quiz Tersedia!</h3>
                <p class="text-sm text-gray-600 mb-3">
                    Test pemahaman Anda dengan quiz ini. 
                    Nilai minimal lulus: {{ $lesson->quiz->passing_score }}%
                </p>
                <a href="{{ route('quiz.show', $lesson->quiz) }}" class="btn-primary">
                    Mulai Quiz
                </a>
            </div>
        @endif
        
        <!-- Comments Section -->
        <x-lesson.comments :lesson="$lesson" />
    </div>
</x-app-layout>
```

#### Teacher Lesson Show (Similar Structure)
Copy student view but add "Create Quiz" and "Edit Lesson" buttons.

---

## 📝 Teacher Forms Update (TODO)

**Files to Update**:
- `resources/views/teacher/lessons/create.blade.php`
- `resources/views/teacher/lessons/edit.blade.php`

**What to Copy from Admin**:
1. Video platform dropdown
2. Video URL input with helper text
3. PDF file upload
4. Enctype="multipart/form-data" in form tag

**Quick Copy Steps**:
```bash
# Copy admin forms as template
cp resources/views/admin/lessons/create.blade.php resources/views/teacher/lessons/create.blade.php
cp resources/views/admin/lessons/edit.blade.php resources/views/teacher/lessons/edit.blade.php

# Then adjust:
# - Change routes from 'admin.lessons.*' to 'teacher.lessons.*'
# - Change layout from <x-app-layout> to <x-layouts.teacher>
# - Keep all video/PDF fields unchanged
```

---

## 🧪 Testing Checklist

### After Migration on Railway:

1. **Test Video Upload**:
   - Login as admin/teacher
   - Create/edit lesson
   - Add YouTube URL: `https://www.youtube.com/watch?v=dQw4w9WgXcQ`
   - Save and verify no errors

2. **Test PDF Upload**:
   - Upload a small PDF (< 10MB)
   - Verify file saved in `storage/app/public/lesson-pdfs/`
   - Check storage link works

3. **Test Quiz Creation**:
   - Visit: `/teacher/quiz/create/{lesson_id}`
   - Create quiz with 3 questions
   - Each question has 4 options
   - Submit and check database

4. **Test Quiz Taking**:
   - Visit: `/quiz/{quiz_id}`
   - Answer all questions
   - Submit and check score
   - Verify attempt saved

5. **Test Comments**:
   - When lesson view exists, test posting comments
   - Test replying to comments
   - Test deleting own comments

---

## ⚠️ Known Limitations

1. **No lesson show views yet** - Need to create Student/Teacher LessonController & views
2. **Teacher lesson forms** - Still use old structure, need update
3. **Video/PDF components** - Created but not integrated (waiting for views)

---

## 📊 Database Tables Added

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `lesson_comments` | Comments & replies | `parent_id`, `user_id`, `lesson_id` |
| `quizzes` | Quiz info | `lesson_id`, `passing_score` |
| `quiz_questions` | Quiz questions | `quiz_id`, `question`, `order` |
| `quiz_options` | Answer options | `question_id`, `is_correct` |
| `quiz_attempts` | Student attempts | `quiz_id`, `user_id`, `score`, `answers` (JSON) |

**Total New Columns in `lessons`**:
- `video_url` (string, nullable)
- `video_platform` (enum: youtube/vimeo/none)
- `pdf_file` (string, nullable)

---

## 🔧 Quick Commands Reference

```bash
# Check migration status
railway run php artisan migrate:status

# Rollback if needed
railway run php artisan migrate:rollback

# Fresh migration (DANGER - drops all data!)
railway run php artisan migrate:fresh

# Check logs
railway logs

# Check storage link
railway run ls -la public/storage
```

---

## 🎯 Next Steps Priority

1. ✅ **DONE**: Fix Lesson model
2. ✅ **DONE**: Enhance validation
3. 🔴 **URGENT**: Run migrations on Railway
4. 🔴 **URGENT**: Link storage on Railway
5. 🟡 **Important**: Create lesson show views (student & teacher)
6. 🟡 **Important**: Update teacher lesson forms
7. 🟢 **Optional**: Add quiz analytics dashboard

---

## 💡 Tips

- **Testing locally**: Make sure Laragon MySQL is running
- **Routes**: All quiz/comment routes already added to `web.php`
- **Components**: All Blade components ready in `resources/views/components/lesson/`
- **Models**: All relationships complete and working

**Need help?** Check logs:
- Local: `storage/logs/laravel.log`
- Railway: `railway logs` command

---

Semua siap! Tinggal run migration di Railway dan buat lesson show views! 🚀
