<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\Result;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('easy quiz')]
class EasyQuiz extends Component
{
    public $title;
    public $quizzes;
    public $quiz;
    public $questions;
    public $answers = [];
    public $score = 0;
    public $multiplier = 100;
    public $number_of_questions;
    public $incorrectQuestions = [];
    public $timeRemaining; // Tambahkan properti untuk menyimpan waktu tersisa

    public function back()
    {
        return redirect('/quiz/easy');
    }

    public function mount($level = 'Easy')
    {
        $this->title = 'Quiz Easy';
        $this->quizzes = Quiz::where('level', $level)->get();
    }

    public function startEasy(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->questions = $quiz->questions;
        $this->score = 0; // Reset score
        $this->incorrectQuestions = []; // Reset incorrect questions
        $this->title = $quiz->title;
        $this->number_of_questions = $quiz->number_of_questions;
        $this->timeRemaining = $quiz->time;
    }

    public function submitEasy()
    {
        // Reset score dan pertanyaan yang salah
        $this->score = 0;
        $this->multiplier = 100 / $this->number_of_questions;
        $this->incorrectQuestions = [];

        foreach ($this->questions as $question) {
            if (isset($this->answers[$question->id])) {
                if ($this->answers[$question->id] == $question->correct_answer) {
                    $this->score += 1;
                } else {
                    $this->incorrectQuestions[] = [
                        'question' => $question->question_text,
                        'your_answer' => 'Jawaban Anda: ' . $this->answers[$question->id],
                        'correct_answer' => $question->correct_answer
                    ];
                }
            } else {
                $this->incorrectQuestions[] = [
                    'question' => $question->question_text,
                    'your_answer' => 'Tidak dijawab',
                    'correct_answer' => $question->correct_answer
                ];
            }
        }

        $this->score = $this->score * $this->multiplier;

        // Simpan hasil kuis ke dalam database
        Result::create([
            'quiz_id' => $this->quiz->id,
            'user_id' => auth()->id(), // Menggunakan user yang sedang login
            'score' => $this->score
        ]);
    }

    public function render()
    {
        return view('livewire.easy-quiz', [
            'quizzes' => $this->quizzes,
            'quiz' => $this->quiz,
            'questions' => $this->questions,
            'score' => $this->score,
            'incorrectQuestions' => $this->incorrectQuestions,
            'timeRemaining' => $this->timeRemaining
        ]);
    }
}
