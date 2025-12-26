<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\TahsinClass;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('tahsinClass')->orderBy('order')->paginate(15);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $tahsinClasses = TahsinClass::where('is_active', true)->orderBy('order')->get();
        return view('admin.lessons.create', compact('tahsinClasses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahsin_class_id' => 'required|exists:tahsin_classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_platform' => 'required|in:youtube,vimeo,none',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'zoom_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('lesson-pdfs', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        Lesson::create($validated);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson berhasil ditambahkan.');
    }

    public function edit(Lesson $lesson)
    {
        $tahsinClasses = TahsinClass::where('is_active', true)->orderBy('order')->get();
        return view('admin.lessons.edit', compact('lesson', 'tahsinClasses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'tahsin_class_id' => 'required|exists:tahsin_classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_platform' => 'required|in:youtube,vimeo,none',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'zoom_link' => 'nullable|url|max:255',
            'order' => 'required|integer|min:0',
        ]);

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($lesson->pdf_file) {
                \Storage::disk('public')->delete($lesson->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('lesson-pdfs', 'public');
            $validated['pdf_file'] = $pdfPath;
        }

        $lesson->update($validated);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson berhasil diupdate.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson berhasil dihapus.');
    }
}
