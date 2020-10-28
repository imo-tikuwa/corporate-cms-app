$(function(){

    // フリーワード検索
    $('#charge_relations-freeword-search-snippet').on('keypress', function(e) {
        if (e.keyCode == 13) {
            $('#charge_relations-freeword-search-btn').trigger('click');
        }
    });
    $('#charge_relations-freeword-search-btn').on('click', function(){
        let freeword_snippet = $('#charge_relations-freeword-search-snippet').val(),
        freeword_snippet_format = $('.charge_relations-freeword-search-snippet-format:checked').val();
        $('#charge_relations-freeword-hidden-search-snippet').val(freeword_snippet);
        $('#charge_relations-freeword-hidden-search-snippet-format').val(freeword_snippet_format);
        $('#charge_relations-freeword-search-form').submit();
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
