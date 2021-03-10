$(() => {

    // フリーワード検索
    $('#charges-freeword-search-snippet').on('keypress', e => {
        if (e.keyCode == 13) {
            $('#charges-freeword-search-btn').trigger('click');
        }
    });

});
