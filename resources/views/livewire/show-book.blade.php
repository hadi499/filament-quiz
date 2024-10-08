<div class="flex w-full justify-center  mt-8 p-2">
    <div>


        <div class="mb-5">
            <a wire:navigate href="{{route('books.index')}}">
                <div
                    class=" border-slate-500 border  text-center hover:bg-slate-800 hover:text-white w-20 py-1 shadow-lg rounded-sm  text-slate-700 text-sm font-semibold ">
                    Back
                </div>
            </a>
        </div>

        <div class="border  p-4 border-blue-400 bg-amber-50 mb-8 lg:w-[1000px]">
            <h1 class="text-center text-2xl font-semibold mb-8">{{ $book->title }}</h1>



            @if($pages->count() > 0)
            @foreach($pages as $page)
            <div class="mb-3" x-data="{ showIndonesian: false }">
                @if ($page->image)
                <img src="{{ asset('storage/' . $page->image) }}" class="card-img-top">

                @endif

                <div class="text-xl  "> {!! $page->english !!}
                    @if (!empty($page->indonesian))
                    <span class="hover:cursor-pointer text-sm text-blue-600 mb-0"
                        @click="showIndonesian = !showIndonesian">
                        terjemahkan</span>
                    @endif


                </div>


                <div x-show="showIndonesian" class="text-lg italic leading-tight">
                    {!! $page->indonesian !!}

                </div>


            </div>
            @endforeach

            @else
            <p>No pages available for this book.</p>
            @endif

        </div>

    </div>



</div>