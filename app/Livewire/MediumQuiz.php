<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\Result;
use Livewire\Component;

class MediumQuiz extends Component
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
    public $timeRemaining;

    public function back()
    {
        return redirect('/quiz');
    }

    public function mount($level = 'Medium')
    {
        $this->title = 'Quiz Medium';
        $this->quizzes = Quiz::where('level', $level)->get();
    }

    public function startMedium(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->score = 0; // Reset score
        $this->incorrectQuestions = []; // Reset incorrect questions
        $this->title = $quiz->title;

        // Atur jumlah pertanyaan dari kuis
        $this->number_of_questions = min($quiz->number_of_questions, $quiz->questions->count());

        // Acak dan ambil sejumlah pertanyaan sesuai dengan $this->number_of_questions
        // $this->questions = $quiz->questions->shuffle()->take($this->number_of_questions);
        $this->questions = $quiz->questions()
            ->inRandomOrder()  // Acak langsung di level query
            ->take($this->number_of_questions)  // Ambil sejumlah pertanyaan
            ->get();

        $this->timeRemaining = $quiz->time; // Set waktu tersisa
    }

    public function submitMedium()
    {
        // Reset score and incorrect questions
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

        // Save quiz result in the database
        Result::create([
            'quiz_id' => $this->quiz->id,
            'user_id' => auth()->id(), // Using the currently authenticated user
            'score' => $this->score
        ]);
    }


    public function render()
    {
        return view('livewire.medium-quiz', [
            'quizzes' => $this->quizzes,
            'quiz' => $this->quiz,
            'questions' => $this->questions,
            'score' => $this->score,
            'incorrectQuestions' => $this->incorrectQuestions,
            'timeRemaining' => $this->timeRemaining
        ]);
    }
}
