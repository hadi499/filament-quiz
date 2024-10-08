<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('page view')]
class ShowBook extends Component
{
    public $book;
    public $pages;
    public $bookId;

    public function mount(Book $book)
    {
        $this->book = $book;

        // Ambil pages yang terkait dengan buku ini
        $this->pages = $book->pages()->get();
    }

    public function render()
    {
        return view('livewire.show-book', [
            'book' => $this->book,
            'pages' => $this->pages,
        ]);
    }
}
