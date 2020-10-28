$(function(){

    // フリーワード検索
    $('#charges-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#charges-freeword-search-btn').trigger('click');
        }
    });
    $('#charges-freeword-search-btn').on('click', function(){
        let freeword_snippet = $('#charges-freeword-search-snippet').val(),
        freeword_snippet_format = $('.charges-freeword-search-snippet-format:checked').val();
        $('#charges-freeword-hidden-search-snippet').val(freeword_snippet);
        $('#charges-freeword-hidden-search-snippet-format').val(freeword_snippet_format);
        $('#charges-freeword-search-form').submit();
    });

});
