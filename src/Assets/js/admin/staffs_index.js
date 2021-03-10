$(() => {

    // フリーワード検索
    $('#staffs-freeword-search-snippet').on('keypress', e => {
        if (e.keyCode == 13) {
            $('#staffs-freeword-search-btn').trigger('click');
        }
    });

    // スタッフ役職
    $('#staff_position').select2({
        theme: "bootstrap4",
        width: 'auto',
        dropdownAutoWidth: true,
    });

    // 画像表示位置
    $('#photo_position').select2({
        theme: "bootstrap4",
        width: 'auto',
        dropdownAutoWidth: true,
    });

});
