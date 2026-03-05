<?php
// C:\Users\Asim\sekkeiShoLrvl\routes\web.php
// web.php (Dispatcher): 必要な「アドレス」を見つけて、リクエストをリダイレクトします。

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// --- 検索 ---
Route::get('/users/searchPage', [UserController::class, 'search'])->name('users.search');

// --- 登録 ---
// 登録画面表示
Route::get('/users/registerPage', [UserController::class, 'registPage'])->name('users.registPage');
// 登録実行
Route::post('/users/registerPage', [UserController::class, 'register'])->name('users.register');

// --- 編集 ---
// 編集画面表示
Route::get('/users/editPage/{user_id}', [UserController::class, 'editPage'])->name('users.editPage');
// 編集実行
Route::post('/users/editPage/{user_id}', [UserController::class, 'edit'])->name('users.edit');

// --- 削除 ---
Route::delete('/users/{user_id}', [UserController::class, 'delete'])->name('users.delete');

// --- CSVなど出力 ---
Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
