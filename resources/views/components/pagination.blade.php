<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\components\pagination.blade.php -->

@php
    // 
    if (!$collection || $collection->total() === 0) {
        return;
    }

    $currentPage = $collection->currentPage();
    $lastPage = $collection->lastPage();
    $total = $collection->total();
    $firstItem = $collection->firstItem();
    $lastItem = $collection->lastItem();
    $currentLimit = $collection->perPage();

    $limitOptions = [10, 15, 20, 50, 100];
@endphp

@if($collection && $collection->total() > 0)
    <div id="custom-pagination-footer" class="flex flex-col lg:flex-row lg:items-center lg:justify-end lg:pr-4 p-2 border-t gap-2 border-gray-300">

        <div class="flex justify-center lg:justify-start items-center text-sm md:text-md lg:text-sm font-medium text-gray-700 gap-0 lg:gap-0">
            <span id="total-records-info" class="whitespace-nowrap mx-2">
                表示中 {{ $firstItem }}-{{ $lastItem }} / {{ $total }}件
            </span>
            
            <div class="flex items-center gap-1">
                <form method="GET" action="{{ url()->current() }}" class="flex items-center">
                    {{-- limit - page --}}
                    @foreach(request()->except(['limit', 'page']) as $key => $value)
                        @if(!is_array($value))
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    {{-- --}}
                    <input type="hidden" name="page" value="1">

                    <label for="limit-select" class="mb-0 font-medium whitespace-nowrap border-l border-gray-300 px-2">
                        表示する行数:
                    </label>

                    <select name="limit" id="limit-select" onchange="this.form.submit()" 
                            class="border border-gray-300 rounded-md px-2 py-1 shadow-sm focus:ring-blue-400 focus:border-blue-400">
                        @foreach($limitOptions as $option)
                            <option value="{{ $option }}" {{ $currentLimit == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-center text-sm md:text-md lg:text-sm gap-2 lg:gap-4">
            {{-- ページセレクト --}}
            <div class="flex justify-center lg:justify-start items-center font-medium text-gray-700 lg:border-r border-gray-300 pr-4">
                <label for="page-select" class="mb-0 font-medium whitespace-nowrap lg:border-l border-gray-300 pl-2 mr-2">
                    ページ番号: 
                </label>
                <select id="page-select" class="border border-gray-300 rounded-md px-2 py-1 shadow-sm focus:ring-blue-400 focus:border-blue-400"
                        onchange="window.location.href = this.value;">
                    @for ($i = 1; $i <= $lastPage; $i++)
                        <option value="{{ $collection->url($i) }}" {{ $i == $currentPage ? 'selected' : '' }}>
                            {{ $i }}/{{ $lastPage }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- ページナビゲーション --}}
            <div class="flex flex-row items-center gap-4">
                {{-- 前へ --}}
                @if ($collection->onFirstPage())
                    <button class="bg-gray-200 text-gray-500 px-5 py-2 rounded-lg font-medium cursor-not-allowed opacity-70" disabled>前へ</button>
                @else
                    <a href="{{ $collection->previousPageUrl() }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition duration-200 ease-in-out shadow-sm">前へ</a>
                @endif

                {{-- 次へ --}}
                @if ($collection->hasMorePages())
                    <a href="{{ $collection->nextPageUrl() }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition duration-200 ease-in-out shadow-sm">次へ</a>
                @else
                    <button class="bg-gray-200 text-gray-500 px-5 py-2 rounded-lg font-medium cursor-not-allowed opacity-70" disabled>次へ</button>
                @endif
            </div>
        </div>
        
    </div>
@endif