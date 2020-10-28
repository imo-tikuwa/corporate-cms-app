$(function(){

    // フリーワード検索
    $('#charge_masters-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#charge_masters-freeword-search-btn').trigger('click');
        }
    });
    $('#charge_masters-freeword-search-btn').on('click', function(){
        let freeword_snippet = $('#charge_masters-freeword-search-snippet').val(),
        freeword_snippet_format = $('.charge_masters-freeword-search-snippet-format:checked').val();
        $('#charge_masters-freeword-hidden-search-snippet').val(freeword_snippet);
        $('#charge_masters-freeword-hidden-search-snippet-format').val(freeword_snippet_format);
        $('#charge_masters-freeword-search-form').submit();
    });

});
