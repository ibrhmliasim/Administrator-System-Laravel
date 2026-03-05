<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\users\search.blade.php -->

@extends('layouts.app')

@section('searchPage')
    <div class="">
        {{-- ヘッダー start --}}
            <div class="flex items-center justify-between pt-4 mb-6">
                <h2 class="text-3xl font-medium flex items-center gap-2">
                    ユーザー検索
                </h2>

                <div class="items-center gap-3 pt-4">
                    <!--新しい登録ページ(users/registPage.blade.php)を開くための「get」リクエスト-->
                    <a href="{{ route('users.registPage') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white hover:text-white px-4 py-2 rounded-lg font-medium inline-block">
                        新規登録
                    </a>
                </div>
            </div>
            <hr class="border-gray-400 my-6">
        {{-- ヘッダー end --}}

        {{-- 検索 start (resources\views\users\_form.blade.php) --}}
            <div class="bg-white shadow p-6 rounded-xl border border-gray-200 mb-8">
                @include('users.partials._searchPanel', [
                    'action' => route('users.search'),
                    'method' => 'GET',
                    'searchData' => request()->all(),
                ])
            </div>
            <hr class="border-gray-400 pt-8">
        {{-- 検索 end --}}


        {{-- テーブル (resources\views\users\partials\_table.blade.php) --}}
        @include('users.partials._table', ['users' => $users])
    </div>
@endsection
