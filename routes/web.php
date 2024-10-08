<?php

use App\Livewire\Home;
use App\Livewire\Books;

use App\Livewire\Login;
use App\Livewire\Score;
use App\Livewire\EasyQuiz;
use App\Livewire\ShowBook;
use App\Livewire\QuizIndex;
use App\Livewire\MediumQuiz;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;

Route::middleware(['auth'])->group(function () {

    Route::get('/', Home::class)->name('home');
    Route::get('/quiz', QuizIndex::class)->name('quiz.index');
    Route::get('/score', Score::class)->name('score');
    Route::get('/books', Books::class)->name('books.index');
    Route::get('/books/{book}', ShowBook::class)->name('books.show');
    Route::get('/quiz/easy', EasyQuiz::class)->name('quiz.easy');
    Route::get('/quiz/medium', MediumQuiz::class)->name('quiz.medium');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});


Route::get('/login', Login::class)->name('login');
