$(() => {

    // 1レコード辺りの 料金詳細 に割り当てるスクリプトをまとめた関数式
    const attachChargeDetailScripts = prefix => {    };

    // 料金詳細 初期表示処理
    $('.charge-detail-row').each((index, element) => {
        attachChargeDetailScripts($(element).data('prefix'));
    });

    // 料金詳細 フォーム増減後のボタンステータス更新処理
    const charge_detail_min_num = 1;
    const charge_detail_max_num = 5;
    const updateChargeDetailButtonStatus = () => {
        $('.append-charge-detail-row, .delete-charge-detail-row').prop('disabled', false);
        let charge_detail_current_num = $('.charge-detail-row').length;
        if (charge_detail_current_num >= charge_detail_max_num) {
            $('.append-charge-detail-row').prop('disabled', true);
        }
        if (charge_detail_current_num === 0 || charge_detail_current_num <= charge_detail_min_num) {
            $('.delete-charge-detail-row').prop('disabled', true);
        }
    };
    updateChargeDetailButtonStatus();

    // 料金詳細 フォーム追加処理
    $('.append-charge-detail-row').on('click', e => {
        let append_index = $('.charge-detail-row').length;
        if (append_index >= charge_detail_max_num) {
            return false;
        }
        $.ajax({
            type: 'get',
            url: '/admin/charges/append-charge-detail-row',
            data: {
                append_index
            },
            dataType: 'html',
            async: false,
        }).done(html => {
            if ($('.charge-detail-row').length > 0) {
                $('.charge-detail-row:last-child').after(html);
            } else {
                $('.charge-detail-nav').after(html);
            }
            let id_prefix = $('.charge-detail-row:eq(' + append_index + ')').data('prefix');
            attachChargeDetailScripts(id_prefix);
            updateChargeDetailButtonStatus();
        });
    });

    // 料金詳細 フォーム削除処理
    $('.delete-charge-detail-row').on('click', e => {
        if ($('.charge-detail-row').length === 0) {
            return false;
        }
        if (confirm('末尾の料金詳細を削除します。')) {
            let last_index = $('.charge-detail-row').length - 1;
            $('.charge-detail-row:eq(' + last_index +')').remove();
            updateChargeDetailButtonStatus();
        }
    });

});
