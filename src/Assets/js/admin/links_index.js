$(() => {

    // CSVインポート
    $('.csv-import-btn').on('click', () => {
        $('#csv-import-file').trigger('click');
    });
    $('#csv-import-file').on('change', () => {
        $('#csv-import-form').submit();
    });

    // Excelインポート
    $('.excel-import-btn').on('click', () => {
        $('#excel-import-file').trigger('click');
    });
    $('#excel-import-file').on('change', () => {
        $('#excel-import-form').submit();
    });

    // フリーワード検索
    $('#links-freeword-search-snippet').on('keypress', e => {
        if (e.keyCode == 13) {
            $('#links-freeword-search-btn').trigger('click');
        }
    });

    // リンクカテゴリ
    $('#category').select2({
        theme: "bootstrap4",
        width: 'auto',
        dropdownAutoWidth: true,
    });

});
