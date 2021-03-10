$(() => {

    // フリーワード検索
    $('#contacts-freeword-search-snippet').on('keypress', e => {
        if (e.keyCode == 13) {
            $('#contacts-freeword-search-btn').trigger('click');
        }
    });

});
