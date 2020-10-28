$(function(){

    // フリーワード検索
    $('#staffs-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#staffs-freeword-search-btn').trigger('click');
        }
    });
    $('#staffs-freeword-search-btn').on('click', function(){
        let freeword_snippet = $('#staffs-freeword-search-snippet').val(),
        freeword_snippet_format = $('.staffs-freeword-search-snippet-format:checked').val();
        $('#staffs-freeword-hidden-search-snippet').val(freeword_snippet);
        $('#staffs-freeword-hidden-search-snippet-format').val(freeword_snippet_format);
        $('#staffs-freeword-search-form').submit();
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
