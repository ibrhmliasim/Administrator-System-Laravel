$(document).ready(function () {
    const $container = $('#belongs-container');
    const $addButton = $('#add-belong-btn');
    const MAX_BELONGINGS = 10;

    const templateHtml = $('#belong-template').html(); // テンプレートHTML取得
    let newBelongCounter = parseInt($container.attr('data-next-index')) || 0; // 次の新規インデックス

    // -------------------------------
    // ヘルパー関数
    // -------------------------------

    // 追加ボタンの制御
    function updateAddButtonState() {
        const currentCount = $container.children('.belongs-group:not(.deleted)').length;
        const disabled = currentCount >= MAX_BELONGINGS;
        
        $addButton.prop('disabled', disabled)
                .toggleClass('cursor-not-allowed opacity-50', disabled);
    }

    // 削除ボタンの表示制御
    function updateDeleteButtons() {
        const currentCount = $container.children('.belongs-group:not(.deleted)').length;
        $container.find('.delete-belong-btn').toggleClass('hidden', currentCount < 1);
    }

    // 見た目番号更新
    function updateVisualNumbers() {
        let index = 0;

        $container.children('.belongs-group').not('.deleted, .hidden').each(function () {
            $(this).find('.belong-number').text((index + 1) + '.');
            index++;
        });

        updateAddButtonState();
        updateDeleteButtons();
    }

    // 新規ブロック作成
    function createNewBlock() {
        const newKey = newBelongCounter;
        const $newGroup = $(templateHtml.replace(/N/g, newKey)); // テンプレートから新規要素を作成

        $newGroup.find(':input').prop('disabled', false);  // 入力可能にする
        $newGroup.removeClass('hidden'); 
        $container.append($newGroup);
        
        newBelongCounter++;
        $container.attr('data-next-index', newBelongCounter);
        updateVisualNumbers();
    }

    // 所属インプット削除処理（ソフト＆ハード統合）
    function deleteBlock($group) {
        const seqNo = $group.find('input[name*="[seq_no]"]').val();

        if (seqNo !== "" && seqNo !== undefined) {
            $group.addClass('deleted').hide(); // ソフト削除
            $group.find('.delete-flag').val('1');
        } else {
            $group.remove(); // 完全に削除
        }

        updateVisualNumbers();
    }

    // -------------------------------
    // イベント
    // -------------------------------
    $addButton.on('click', createNewBlock);

    $container.on('click', '.delete-belong-btn', function () {
        deleteBlock($(this).closest('.belongs-group'));
    });

    $('#register-submit-btn').on('click', function(e) {
        e.preventDefault();

        if (confirm('登録してもよろしいですか?')) {
            alert('登録しました。');
            $(this).closest('form')[0].submit(); 
        } else {
            return false;
        }
    });

    $('#edit-submit-btn').on('click', function(e) {
        e.preventDefault();

        if (confirm('更新してもよろしいですか?')) {
            alert('更新しました。');
            $(this).closest('form').submit(); 
        } else {
            return false;
        }
    });
    
    // 削除リンクのカスタム処理
    $('#delete-link').on('click', function() {
        // ユーザーが確認した場合、POST が送信される前にアラートを表示します
        let isConfirmed = confirm('削除してもよろしいですか？');
        if (isConfirmed) {
            alert('削除しました。');
        }
        return isConfirmed;
    });

    // 初期化
    updateVisualNumbers();
});
