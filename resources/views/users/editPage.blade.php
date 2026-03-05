<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\users\editPage.blade.php -->

@extends('layouts.app')

@section('editPage')
    <div class="space-y-8 users register content py-8">
        <h2 class="text-3xl font-bold text-gray-700 mb-6 flex items-center gap-2">
            ユーザー編集：{{ $user->login_id }}
        </h2>
        
        <hr class="border-gray-500 my-6">

        <div class="bg-white p-8 rounded-xl">
            <form action="{{ route('users.editPage', ['user_id' => $user->user_id]) }}" method="POST" id="editForm">
                @csrf 
                <fieldset class="space-y-6">
                    <!-- ユーザーが入力する必要があるフォームフィールド -->
                        @include('users.partials._formFields')

                    <!-- 所属情報 -->
                        <div class="flex flex-wrap items-center font-medium border-gray-300 pt-4 gap-10">
                            <div class="text-lg text-gray-700 sm:mb-0 sm:w-52 sm:shrink-0">所属情報:</div>

                            <!-- 所属追加ボタン（クリックでテンプレート行を複製して追加） -->
                            <button type="button" id="add-belong-btn" 
                                class="cursor-pointer text-lg bg-green-500 hover:bg-green-600 text-white border-none px-4 py-2 rounded-lg shadow-md">
                                + 所属を追加 
                            </button>
                        </div>

                    <!-- 所属行テンプレート（非表示）- 新規追加時に JS が N を置き換えて挿入する -->
                        <template id="belong-template">
                            <div class="belongs-group flex items-baseline" data-index="N">
                                <div class="belong-number pr-4 font-semibold w-6 text-right">X.</div>

                                <div class="flex flex-col">
                                    <div class="flex items-center gap-4">
                                        <input type="hidden" name="t_user_belongs[N][user_id]" value="{{ $user->user_id }}">
                                        <input type="hidden" name="t_user_belongs[N][seq_no]" value="">
                                        <input type="hidden" name="t_user_belongs[N][_delete]" value="0" class="delete-flag">
                                        
                                        <input type="text" 
                                            name="t_user_belongs[N][belongs_name]" 
                                            class="belong-input w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm" 
                                            placeholder="所属名">
                                    </div>
                                    <div class="error-message text-red-500 text-sm mt-1"></div>
                                </div>

                                <button type="button" 
                                        class="delete-belong-btn ml-4 bg-red-600 hover:bg-red-700 border-none px-3 py-1 rounded-lg text-lg text-white cursor-pointer">
                                    削除
                                </button>
                            </div>
                        </template>

                    <!-- 既存の所属データ一覧 -->
                        <div id="belongs-container" class="space-y-4 pl-8 pt-4 sm:ml-48" data-next-index="{{ $nextIndex }}">
                            @foreach($belongsData as $key => $belong)
                                @php
                                    // $belong は old() から来れば配列、DBから来ればオブジェクトの可能性があるため変換
                                    $item  = (array)$belong;
                                    $bName = $item['belongs_name'] ?? '';
                                    $bSeq  = $item['seq_no'] ?? '';
                                    $bDel  = $item['_delete'] ?? '0';
                                @endphp

                                <div class="belongs-group flex items-baseline {{ $bDel == '1' ? 'hidden' : '' }}" data-index="{{ $key }}">
                                    <div class="belong-number pr-4 font-semibold w-6 text-right">{{ $loop->iteration }}.</div>

                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-4">
                                            {{-- インデックスとして $key を使用することでバリデーションエラーと紐付けます --}}
                                            <input type="hidden" name="t_user_belongs[{{ $key }}][user_id]" value="{{ $user->user_id }}">
                                            <input type="hidden" name="t_user_belongs[{{ $key }}][seq_no]" value="{{ $bSeq }}">
                                            <input type="hidden" name="t_user_belongs[{{ $key }}][_delete]" value="{{ $bDel }}" class="delete-flag">
                                            
                                            <input type="text" 
                                                name="t_user_belongs[{{ $key }}][belongs_name]" 
                                                value="{{ $bName }}" 
                                                class="belong-input w-full px-4 py-2 border rounded-sm shadow-sm @error("t_user_belongs.$key.belongs_name") border-red-500 @else border-gray-400 @enderror"
                                                placeholder="所属名">
                                        </div>

                                        {{-- エラーメッセージの表示（キーに基づいた正確な表示） --}}
                                        @error("t_user_belongs.$key.belongs_name")
                                            <div class="text-red-500 font-medium text-sm leading-tight mt-2">必須項目です。</div>
                                        @enderror
                                    </div>

                                    <button type="button" class="delete-belong-btn ml-4 bg-red-600 hover:bg-red-700 border-none px-3 py-1 rounded-lg text-lg text-white cursor-pointer">
                                        削除
                                    </button>
                                </div>
                            @endforeach
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
                            更新
                        </button>
                    </div>
                </div>
            </form>

            <!-- このユーザーを削除する -->
            <div class="flex justify-end">
                <form action="{{ route('users.delete', $user->user_id) }}" method="POST" 
                    onsubmit="">
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit" 
                            id="delete-link" 
                            class="text-blue-600 hover:underline bg-transparent pr-5 text-lg font-normal shadow-none border-none cursor-pointer">
                        {{ __('このユーザーを削除する') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    @vite(['resources/js/belongingsHandler.js'])

@endpush