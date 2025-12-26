<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Show quiz to student
     */
    public function show(Quiz $quiz)
    {
        $quiz->load('questions.options');
        
        // Get user's previous attempts
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        $bestAttempt = $attempts->sortByDesc('score')->first();
        
        return view('student.quiz.show', compact('quiz', 'attempts', 'bestAttempt'));
    }

    /**
     * Submit quiz and calculate score
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|exists:quiz_options,id',
        ]);

        // Load quiz with questions and correct options
        $quiz->load('questions.options');
        
        $totalQuestions = $quiz->questions->count();
        $correctAnswers = 0;
        $answersDetail = [];

        foreach ($quiz->questions as $question) {
            $userAnswerId = $validated['answers'][$question->id] ?? null;
            $correctOption = $question->correctOption();
            
            $isCorrect = ($userAnswerId == $correctOption->id);
            if ($isCorrect) {
                $correctAnswers++;
            }
            
            $answersDetail[$question->id] = [
                'selected' => $userAnswerId,
                'correct' => $correctOption->id,
                'is_correct' => $isCorrect,
            ];
        }

        $score = ($correctAnswers / $totalQuestions) * 100;
        $passed = ($score >= $quiz->passing_score);

        // Save attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => auth()->id(),
            'score' => $score,
            'answers' => $answersDetail,
            'passed' => $passed,
            'completed_at' => now(),
        ]);

        return redirect()->route('quiz.show', $quiz)
            ->with('success', "Quiz selesai! Skor Anda: {$score}% " . ($passed ? '(LULUS ✅)' : '(BELUM LULUS ❌)'));
    }
}
