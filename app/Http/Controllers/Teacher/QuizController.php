<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Show quiz creation form for a lesson
     */
    public function create(Lesson $lesson)
    {
        return view('teacher.quiz.create', compact('lesson'));
    }

    /**
     * Store a new quiz with questions and options
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.correct_option' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            // Create quiz
            $quiz = Quiz::create([
                'lesson_id' => $validated['lesson_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'passing_score' => $validated['passing_score'],
                'is_active' => true,
            ]);

            // Create questions and options
            foreach ($validated['questions'] as $qIndex => $questionData) {
                $question = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'order' => $qIndex,
                ]);

                foreach ($questionData['options'] as $oIndex => $optionData) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionData['text'],
                        'is_correct' => ($oIndex == $questionData['correct_option']),
                        'order' => $oIndex,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('teacher.lessons.index')->with('success', 'Quiz berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat quiz: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('teacher.quiz.edit', compact('quiz'));
    }

    /**
     * Update quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Similar to store, but updating existing quiz
        // For simplicity, we'll just update basic info
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update($validated);
        return redirect()->route('teacher.lessons.index')->with('success', 'Quiz berhasil diupdate!');
    }

    /**
     * Delete quiz
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete(); // Cascade will delete questions, options, attempts
        return back()->with('success', 'Quiz berhasil dihapus!');
    }
}
