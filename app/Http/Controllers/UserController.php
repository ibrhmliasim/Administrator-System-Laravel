<?php
// C:\Users\Asim\sekkeiShoLrvl\app\Http\Controllers\UserController.php
// コントローラー: リクエストからクリーンなデータを受信し、サービスに「先に進んでください」と指示します。
// その後サービスから結果を受け取り、適切なbladeを呼び出します。

namespace App\Http\Controllers;

// --- モデル ---
use App\Models\TUser;

// --- システム・フレームワーク関連 ---
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Exception;

// --- フォームリクエスト (バリデーション) ---
use App\Http\Requests\User\SearchUserRequest;
use App\Http\Requests\User\RegistUserRequest;
use App\Http\Requests\User\EditUserRequest;

// --- サービスクラス (ビジネスロジック) ---
use App\Services\User\UserSearchService;
use App\Services\User\UserRegisterService;
use App\Services\User\UserEditService;
use App\Services\User\UserDeleteService;
use App\Contracts\User\UserExportInterface;

class UserController extends Controller {

    /**
     * ユーザー一覧画面の表示および検索処理
     *
     * @param \App\Http\Requests\SearchUserRequest $request 検索リクエスト
     * @param \App\Services\User\UserSearchService $service 検索サービス
     * @return \Illuminate\View\View ユーザー一覧画面
     */
    public function search(SearchUserRequest $request, UserSearchService $service): View {
        $users = $service->searchService($request->searchData());
        return view('users.searchPage', compact('users'));
    }

    /**
     * ユーザー登録画面の表示 (GET)
     *
     * @return \Illuminate\View\View ユーザー登録画面
     */
    public function registPage(): View {
        $belongsData = old('t_user_belongs', []);

        $nextIndex = 0;
        if (!empty($belongsData)) {
            $keys = array_filter(array_keys($belongsData), 'is_numeric');
            $nextIndex = !empty($keys) ? max($keys) + 1 : count($belongsData);
        }

        return view('users.registPage', compact('belongsData', 'nextIndex'));
    }

    /**
     * ユーザー登録処理(POST)
     * 
     * @param RegistUserRequest $request
     * @param UserRegisterService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegistUserRequest $request, UserRegisterService $service) {

        try {
            // 1. サービスを呼び出す
            $service->registerService($request->registerData());

            // 2. 成功メッセージを含むリダイレクトが送信されます。
            return redirect()->route('users.search')
                ->with('success', 'ユーザー登録が完了しました。');
                
        } catch (\Exception $e) {
            // 3. 失敗した場合
            Log::error('User Registration Error: ' . $e->getMessage());

            // 入力したデータとエラーを返します
            return back()
                ->withInput()
                ->with('error', 'ユーザーの登録に失敗しました');
        }
    }

    /**
     * ユーザー編集画面の表示 (GET)
     *
     * @param int|string $user_id ユーザーID
     * @return \Illuminate\View\View
     */
    public function editPage($user_id) {
        // ユーザー情報を取得。存在しない場合は自動的に404エラーを返却。
        $user = TUser::with('userBelongs')->findOrFail($user_id);

        // 所属情報のデータ制御
        $oldInput = old('t_user_belongs');
    
        if (!is_null($oldInput)) {
            $belongsData = $oldInput;
        } else {
            $belongsData = $user->userBelongs->keyBy('seq_no')->toArray();
        }

        // 既存の最大キー + 1
        $existingKeys = array_keys($belongsData);
        $nextIndex = count($existingKeys) > 0 
            ? max(array_filter($existingKeys, 'is_numeric') ?: [0]) + 1 
            : 1;

        return view('users.editPage', compact('user', 'belongsData', 'nextIndex'));
    }

    /**
     * ユーザー情報の更新処理 (POST)
     *
     * @param \App\Http\Requests\EditUserRequest $request 編集リクエスト
     * @param \App\Services\User\UserEditService $service 編集サービス
     * @param int|string $user_id ユーザーID
     * @return \Illuminate\Http\RedirectResponse 検索画面へのリダイレクト
     */
    public function edit (EditUserRequest $request, UserEditService $service, $user_id) {
        try {
            // まず、編集対象のユーザーをデータベースから取得する
            $user = TUser::findOrFail($user_id);

            // サービスを呼び出す (ユーザーオブジェクトと、バリデーション済みデータを渡す)
            $service->editService($user, $request->editData());

            // 成功メッセージを含むリダイレクト
            return redirect()->route('users.search')
                ->with('success', 'ユーザー編集が完了しました。');
                
        } catch (\Exception $e) {
            // 失敗した場合
            Log::error('User Edit Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'ユーザーの編集に失敗しました: ' . $e->getMessage());
        }
    }

    /**
     * ユーザー削除処理 (POST)
     * 
     * @param int|string $user_id ユーザーID
     * @param \App\Services\User\UserDeleteService $service 削除サービス
     * @return \Illuminate\Http\RedirectResponse 検索画面へのリダイレクト
     */
    public function delete ($user_id, UserDeleteService $service) {
        if (!$user_id) {
            return redirect()->route('users.search')->with('error', 'ユーザーIDが指定されていません');
        }

        $result = $service->userDeleteService($user_id);

        if ($result['status'] === 'success') {
            return redirect()->route('users.search', ['deleted' => 1]);
        }

        return redirect()->route('users.search')->with('error', $result['message']);
    }

    /**
     * ユーザー情報のCSVエクスポート処理
     *
     * @param \Illuminate\Http\Request $request リクエストオブジェクト
     * @param \App\Services\User\UserExportService $exportService CSV出力サービス
     * @param \App\Services\User\UserSearchService $searchService 検索サービス
     * @return \Symfony\Component\HttpFoundation\StreamedResponse CSVストリームレスポンス
     */
    public function export(Request $request, UserExportInterface $exportInterface): StreamedResponse
    {
        return $exportInterface->export($request->all());
    }
}
