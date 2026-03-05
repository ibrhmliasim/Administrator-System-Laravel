<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\users\_form.blade.php -->

@php
    $currentGender = request()->has('gender')
        ? (string) request('gender')
        : (string) ($searchData['gender'] ?? '');
@endphp

<!-- 検索 START -->
    <form method="{{ $method ?? 'GET' }}" action="{{ $action }}">
        @if(strtoupper($method ?? 'GET') === 'POST') @csrf @endif
        
        <fieldset class="space-y-8">
            <legend class="font-semibold text-gray-700 mb-2">検索パラメータ</legend>
            <!-- グループ１ -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- ログインID -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <label for="login_id" class="text-gray-700 font-medium lg:w-22 lg:shrink-0 sm:w-52 sm:shrink-0">
                        ログインID:
                    </label>
                    <input type="text" name="login_id" id="login_id" 
                        value="{{ request('login_id') }}"
                        class="border rounded-lg px-3 py-2 grow focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- 氏名 -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <label for="name" class="text-gray-700 font-medium lg:w-16 shrink-0 sm:w-52 sm:shrink-0">
                        氏名:
                    </label>
                    <input type="text" name="full_name" id="full_name" 
                        value="{{ request('full_name') }}"
                        class="border rounded-lg px-3 py-2 grow focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- 生年月日 -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <label for="birthday" class="text-gray-700 font-medium lg:w-22 shrink-0 sm:w-52 sm:shrink-0">
                        生年月日:
                    </label>
                    <input type="text" name="birthday" id="birthday" 
                        value="{{ request('birthday') }}"
                        placeholder="例: 1990/12/02"
                        class="border rounded-lg px-3 py-2 grow focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- グループ２ -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- 性別 -->
                <div class="md:flex lg:flex items-center sm:items-center gap-2 lg:gap-11">
                    <span class="text-gray-700 font-medium lg:w-16 shrink-0 sm:w-52 sm:shrink-0">性別:</span>
                    
                    <div class="flex flex-row justify-center md:justify-start gap-[1.8rem] md:gap-[0.44rem] lg:gap-[1.6rem] grow py-1">
                        @foreach(config('user.gender') as $value => $label)
                            <label class="flex items-center text-gray-700 cursor-pointer font-medium">
                                <input type="radio"
                                    name="gender"
                                    value="{{ (string)$value }}"
                                    {{ $currentGender === (string)$value ? 'checked' : '' }}
                                    class="mr-1">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 所属 -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <label for="belongs_name" class="text-gray-700 font-medium lg:w-16 shrink-0 sm:w-52 sm:shrink-0">
                        所属:
                    </label>
                    <input type="text" name="belongs_name" id="belongs_name" 
                        value="{{ request('belongs_name') }}"
                        class="border rounded-lg px-3 py-2 grow focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <!-- 検索ボタン -->
            <div class="flex justify-center pt-4">
                <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium cursor-pointer">
                    検索
                </button>
            </div>
            
        </fieldset>
    </form>
<!-- 検索 END -->