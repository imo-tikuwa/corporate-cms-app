$(function(){

    // フリーワード検索
    $('#charge_masters-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#charge_masters-freeword-search-btn').trigger('click');
        }
    });

});
