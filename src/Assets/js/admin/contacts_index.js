$(function(){

    // フリーワード検索
    $('#contacts-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#contacts-freeword-search-btn').trigger('click');
        }
    });
    $('#contacts-freeword-search-btn').on('click', function(){
        let freeword_snippet = $('#contacts-freeword-search-snippet').val(),
        freeword_snippet_format = $('.contacts-freeword-search-snippet-format:checked').val();
        $('#contacts-freeword-hidden-search-snippet').val(freeword_snippet);
        $('#contacts-freeword-hidden-search-snippet-format').val(freeword_snippet_format);
        $('#contacts-freeword-search-form').submit();
    });

});
