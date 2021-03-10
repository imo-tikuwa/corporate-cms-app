$(() => {

    // フリーワード検索
    $('#charge_relations-freeword-search-snippet').on('keypress', e => {
        if (e.keyCode == 13) {
            $('#charge_relations-freeword-search-btn').trigger('click');
        }
    });

    // 基本料金ID
    $('#charge_id').select2({
        theme: "bootstrap4",
        width: 'auto',
        dropdownAutoWidth: true,
    });

    // 料金マスタID
    $('#charge_master_id').select2({
        theme: "bootstrap4",
        width: 'auto',
        dropdownAutoWidth: true,
    });

});
