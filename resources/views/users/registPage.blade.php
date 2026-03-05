<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\users\registPage.blade.php -->

@extends('layouts.app')

@section('registPage')
    <div class="space-y-8 users register content py-8">
        <h2 class="text-3xl font-bold text-gray-700 mb-6 flex items-center gap-2">
            新規ユーザー登録
        </h2>
        
        <hr class="border-gray-500 my-6">

        <div class="bg-white p-8 rounded-xl">
            <form action="{{ route('users.register') }}" method="POST" id="registerForm">
                @csrf 
                <fieldset class="space-y-6">
                    <!-- ユーザーが入力する必要があるフォームフィールド -->
                        @include('users.partials._formFields')

                    <!-- 所属情報 -->
                        <div class="flex flex-wrap items-center font-medium border-gray-300 pb-2 pt-4 gap-10">
                            <div class="text-lg text-gray-700 sm:mb-0 sm:w-52 sm:shrink-0">所属情報:</div>

                            <!-- 所属追加ボタン（クリックでテンプレート行を複製して追加） -->
                            <button type="button" id="add-belong-btn" 
                                class="cursor-pointer text-lg bg-green-500 hover:bg-green-600 text-white border-none px-4 py-2 rounded-lg shadow-md">
                                + 所属を追加 
                            </button>
                        </div>
                    <!-- テンプレート行（非表示）- belongs-container とは別に配置することで、JS が安全に複製できるようにする -->
                        <template id="belong-template">
                            <div class="belongs-group flex items-center" data-index="N">
                                <!-- 表示番号（1〜）。JS 側で追加時に付け直す -->
                                <div class="belong-number pr-8 font-semibold w-6 text-right"></div>

                                <div class="flex">
                                    <div class="w-full max-w-md">
                                        <!-- 既存レコード用の ID（新規は disabled のまま送信しない） -->
                                        <input type="hidden" name="t_user_belongs[N][user_id]" disabled="disabled">
                                        <!-- 既存レコード用の seq_no（新規は disabled のまま送信しない） -->
                                        <input type="hidden" name="t_user_belongs[N][seq_no]" disabled="disabled">
                                        <!-- 論理削除フラグ。既存行では削除ボタン押下で "1" を設定 -->
                                        <input type="hidden" name="t_user_belongs[N][_delete]" class="delete-flag" disabled="disabled">
                                        <!-- 所属名（新規行では JS により disabled を解除） -->
                                        <input type="text" 
                                            name="t_user_belongs[N][belongs_name]" 
                                            class="belong-input w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('login_id') border-red-500 @enderror" 
                                            data-index="N" 
                                            disabled="disabled" 
                                            placeholder="所属名">
                                    </div>

                                    <div>
                                        <div class="error-message text-red-500 text-xs mt-1">
                                            <!-- JSで動的にエラーを挿入する場合はここを使用 -->
                                        </div>
                                    </div>
                                    
                                </div>

                                <button type="button"
                                        class="delete-belong-btn ml-4 bg-red-600 hover:bg-red-700 border-none px-3 py-1 rounded-lg text-lg text-white cursor-pointer">
                                    削除
                                </button>
                            </div>
                        </template>
                    <!-- 実データ（初期表示） -->
                        <div id="belongs-container" class="space-y-4 pl-6 sm:ml-48" data-next-index="{{ $nextIndex }}">
                            @if(count($belongsData) > 0)
                                @foreach($belongsData as $i => $belong)
                                    <div class="belongs-group flex items-baseline" data-index="{{ $i }}">
                                        <div class="belong-number pr-8 font-semibold w-6 text-right">{{ $i + 1 }}.</div>

                                        <div class="flex flex-col">
                                            <input type="text" 
                                                name="t_user_belongs[{{ $i }}][belongs_name]" 
                                                value="{{ $belong['belongs_name'] ?? '' }}"
                                                class="belong-input w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error("t_user_belongs.$i.belongs_name") border-red-500 @enderror">

                                            @error("t_user_belongs.$i.belongs_name")
                                                <div class=" text-red-500 font-medium text-sm leading-tight mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="button" class="delete-belong-btn ml-4 bg-red-600 hover:bg-red-700 border-none px-3 py-1 rounded-lg text-lg text-white cursor-pointer">
                                            削除
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                </fieldset>

                <hr class="border-gray-500 my-6">

                <!-- ボタン -->
                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('users.search') }}" 
                    class="flex items-center text-md bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium shadow-xl transition cursor-pointer">
                        戻る
                    </a>

                    <div class="flex sm:absolute sm:left-1/2 sm:-translate-x-1/2">
                        <button type="submit" id="register-submit-btn" 
                                class="text-lg bg-blue-600 hover:bg-blue-700 text-white border-none px-4 py-2 rounded-lg font-medium shadow-xl transition mx-auto cursor-pointer">
                            新規登録
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')

    @vite(['resources/js/belongingsHandler.js'])

@endpush