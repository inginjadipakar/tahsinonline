<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    private function getSelectedClass($teacher)
    {
        $teacherClasses = $teacher->getTeacherClasses();
        $selectedClassId = session('selected_class_id');
        return $selectedClassId ? $teacherClasses->find($selectedClassId) : $teacherClasses->first();
    }

    public function index(Request $request)
    {
        $teacher = $request->user();
        $assignedClass = $this->getSelectedClass($teacher);

        if (!$assignedClass) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        // Get lessons for assigned class
        $lessons = Lesson::where('tahsin_class_id', $assignedClass->id)
            ->orderBy('order')
            ->paginate(15);

        return view('teacher.lessons.index', compact('lessons', 'assignedClass'));
    }

    public function create(Request $request)
    {
        $teacher = $request->user();
        $assignedClass = $this->getSelectedClass($teacher);

        if (!$assignedClass) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        return view('teacher.lessons.create', compact('assignedClass'));
    }

    public function store(Request $request)
    {
        $teacher = $request->user();
        $assignedClass = $this->getSelectedClass($teacher);

        if (!$assignedClass) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => [
                'nullable',
                'url',
                function ($attribute, $value, $fail) {
                    if ($value && !$this->isValidVideoUrl($value)) {
                        $fail('Video URL harus dari YouTube atau Google Drive.');
                    }
                },
            ],
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // 10MB
            'order' => 'required|integer|min:0',
        ]);

        // Handle file upload
        $filePath = null;
        $fileType = null;
        $fileSize = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('lessons', $fileName, 'local');
            $fileType = $file->getClientOriginalExtension();
            $fileSize = round($file->getSize() / 1024); // Convert to KB
        }

        // Create lesson
        Lesson::create([
            'tahsin_class_id' => $assignedClass->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'created_by' => $teacher->id,
            'order' => $validated['order'],
        ]);

        return redirect()->route('teacher.lessons.index')
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit(Request $request, Lesson $lesson)
    {
        $teacher = $request->user();

        // Authorization: check if lesson's class is one of teacher's classes
        if (!$teacher->getTeacherClasses()->contains('id', $lesson->tahsin_class_id)) {
            abort(403, 'Unauthorized action.');
        }

        $assignedClass = \App\Models\TahsinClass::find($lesson->tahsin_class_id);

        return view('teacher.lessons.edit', compact('lesson', 'assignedClass'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $teacher = $request->user();

        // Authorization
        if (!$teacher->getTeacherClasses()->contains('id', $lesson->tahsin_class_id)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => [
                'nullable',
                'url',
                function ($attribute, $value, $fail) {
                    if ($value && !$this->isValidVideoUrl($value)) {
                        $fail('Video URL harus dari YouTube atau Google Drive.');
                    }
                },
            ],
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'order' => 'required|integer|min:0',
            'remove_file' => 'nullable|boolean',
        ]);

        // Handle file upload/removal
        $filePath = $lesson->file_path;
        $fileType = $lesson->file_type;
        $fileSize = $lesson->file_size;

        // Remove file if requested
        if ($request->has('remove_file') && $request->remove_file) {
            if ($lesson->file_path) {
                Storage::disk('local')->delete($lesson->file_path);
            }
            $filePath = null;
            $fileType = null;
            $fileSize = null;
        }

        // Upload new file
        if ($request->hasFile('file')) {
            // Delete old file
            if ($lesson->file_path) {
                Storage::disk('local')->delete($lesson->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('lessons', $fileName, 'local');
            $fileType = $file->getClientOriginalExtension();
            $fileSize = round($file->getSize() / 1024);
        }

        // Update lesson
        $lesson->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'order' => $validated['order'],
        ]);

        return redirect()->route('teacher.lessons.index')
            ->with('success', 'Materi berhasil diupdate!');
    }

    public function destroy(Request $request, Lesson $lesson)
    {
        $teacher = $request->user();

        // Authorization
        if (!$teacher->getTeacherClasses()->contains('id', $lesson->tahsin_class_id)) {
            abort(403, 'Unauthorized action.');
        }

        // Delete file if exists
        if ($lesson->file_path) {
            Storage::disk('local')->delete($lesson->file_path);
        }

        $lesson->delete();

        return redirect()->route('teacher.lessons.index')
            ->with('success', 'Materi berhasil dihapus!');
    }

    public function download(Request $request, Lesson $lesson)
    {
        $teacher = $request->user();

        // Authorization
        if (!$teacher->getTeacherClasses()->contains('id', $lesson->tahsin_class_id)) {
            abort(403, 'Unauthorized action.');
        }

        if (!$lesson->file_path || !Storage::disk('local')->exists($lesson->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('local')->download($lesson->file_path);
    }

    /**
     * Validate if URL is from YouTube or Google Drive
     */
    private function isValidVideoUrl($url)
    {
        // YouTube patterns
        $youtubePatterns = [
            '/^https?:\/\/(www\.)?youtube\.com\/watch\?v=/',
            '/^https?:\/\/(www\.)?youtu\.be\//',
            '/^https?:\/\/(www\.)?youtube\.com\/embed\//',
        ];

        // Google Drive pattern
        $drivePattern = '/^https?:\/\/drive\.google\.com\//';

        foreach ($youtubePatterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }

        if (preg_match($drivePattern, $url)) {
            return true;
        }

        return false;
    }
}
