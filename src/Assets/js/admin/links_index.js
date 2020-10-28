$(function(){

    // フリーワード検索
    $('#links-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#links-freeword-search-btn').trigger('click');
        }
    });
    $('#links-freeword-search-btn').on('click', function(){
        let freeword_snippet = $('#links-freeword-search-snippet').val(),
        freeword_snippet_format = $('.links-freeword-search-snippet-format:checked').val();
        $('#links-freeword-hidden-search-snippet').val(freeword_snippet);
        $('#links-freeword-hidden-search-snippet-format').val(freeword_snippet_format);
        $('#links-freeword-search-form').submit();
    });

    // リンクカテゴリ
    $('#category').select2({
        theme: "bootstrap4",
        width: 'auto',
        dropdownAutoWidth: true,
    });

});
