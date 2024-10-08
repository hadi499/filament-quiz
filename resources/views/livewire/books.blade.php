<div>
    <div class="flex  justify-center mt-8">
        <div class="w-[300px]">
            <div class="mb-5">
                <a wire:navigate href="{{route('home')}}">
                    <div
                        class=" border-slate-500 border  text-center hover:bg-slate-800 hover:text-white w-20 py-1 shadow-lg rounded-sm  text-slate-700 text-sm font-semibold ">
                        Back
                    </div>
                </a>
            </div>

            @foreach ($books as $book)
            <a wire:navigate href="{{ route('books.show', ['book' => $book->id]) }}"">
                <div
                    class=" border border-blue-700 hover:bg-blue-700 hover:text-white px-2 py-2 shadow-lg rounded-sm
                text-blue-700 text-sm text-center font-semibold mb-4">
                {{ $book->title }}
        </div>
        </a>
        @endforeach


    </div>


</div>
</div>