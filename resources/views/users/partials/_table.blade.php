<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\users\_table.blade.php -->

{{-- CSV出力ボタン start --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('users.export', request()->query()) }}" 
        class="button-export-btn text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-medium inline-block">
            CSV出力
        </a>
    </div>
{{-- CSV出力ボタン end --}}


{{-- ユーザーテーブル start --}}
    <div class="flex flex-col h-full border border-gray-300">
        <div class="tableMain grow text-sm">
            <div class="overflow-x-auto l:overflow-x-hidden sm:overflow-x-auto">
                <table class="min-w-full table-auto"> 
                    <thead class="bg-gray-100 text-gray-700 text-md">
                        <tr> 
                            <th class="p-3 text-center font-medium border-b border-gray-300">ログインID</th>
                            <th class="p-3 text-center font-medium border-b border-gray-300">氏名</th>
                            <th class="p-3 text-center font-medium border-b border-gray-300">生年月日</th>
                            <th class="p-3 text-center font-medium border-b border-gray-300">性別</th>
                            <th class="p-3 text-center font-medium border-b border-gray-300">メールアドレス</th>
                            <th class="p-3 text-center font-medium border-b border-gray-300">電話番号</th>
                        </tr>
                    </thead>

                    <tbody class='text-md' >
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-center font-mono ">                                     
                                    <a href="{{ route('users.editPage', ['user_id' => $user->user_id]) }}" 
                                    class="text-blue-600 hover:underline" 
                                    title="ユーザー編集">
                                        {{ $user->login_id ?? '///' }}
                                    </a>
                                </td>
                                <td class="p-3 text-center whitespace-nowrap ">
                                    {{ $user->user_surname }} {{ $user->user_name }}
                                </td>
                                <td class="p-3 text-center whitespace-nowrap ">
                                    {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('Y/m/d') : '—' }}
                                </td>
                                <td class="p-3 text-center ">
                                    {{ config('user.gender')[$user->gender] ?? '—' }}
                                </td>
                                <td class="p-3 text-center ">{{ $user->email }}</td>
                                <td class="p-3 text-center whitespace-nowrap ">{{ $user->tel }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-lg text-gray-500">
                                    該当するレコードが見つかりません
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="sticky -bottom-px w-full bg-white z-10">
                {{-- ページネーション --}}
                @include('components.pagination', ['collection' => $users])
            </div>
        </div>
    </div>
{{-- ユーザーテーブル end --}}