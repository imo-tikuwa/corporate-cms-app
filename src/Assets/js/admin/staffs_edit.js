$(function(){

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

    // スタッフ画像
    var photo_csrf_token = $("input[name='_csrfToken']").val();
    $("#photo-file-input").fileinput({
        language: "ja",
        theme: "explorer-fas",
        maxFileSize: 264000,
        uploadUrl: "/admin/staffs/fileUpload/photo_file",
        uploadAsync: true,
        showUpload: true,
        showCancel: false,
        showClose: false,
        showRemove: false,
        dropZoneEnabled: false,
        removeFromPreviewOnError: true,
        autoOrientImage: false,
        uploadExtraData: {
            "_csrfToken": photo_csrf_token,
        },
        deleteExtraData: {
            "_csrfToken": photo_csrf_token,
        },
        overwriteInitial: false,
        initialPreview: $("#photo-file-hidden").data('initial-preview'),
        initialPreviewAsData: true,
        initialPreviewConfig: $("#photo-file-hidden").data('initial-preview-config'),
        preferIconicPreview: true,
        previewFileIconSettings: {
            'doc': '<i class="fas fa-file-word text-primary"></i>',
            'xls': '<i class="fas fa-file-excel text-success"></i>',
            'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
            'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
            'zip': '<i class="fas fa-file-archive text-muted"></i>',
            'htm': '<i class="fas fa-file-code text-info"></i>',
            'txt': '<i class="fas fa-file-text text-info"></i>',
            'mov': '<i class="fas fa-file-video text-warning"></i>',
            'mp3': '<i class="fas fa-file-audio text-warning"></i>',
            'jpg': '<i class="fas fa-file-image text-danger"></i>',
            'gif': '<i class="fas fa-file-image text-muted"></i>',
            'png': '<i class="fas fa-file-image text-primary"></i>'
        },
        previewFileExtSettings: {
            'doc': function(ext) {
                return ext.match(/(doc|docx)$/i);
            },
            'xls': function(ext) {
                return ext.match(/(xls|xlsx)$/i);
            },
            'ppt': function(ext) {
                return ext.match(/(ppt|pptx)$/i);
            },
            'zip': function(ext) {
                return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            },
            'htm': function(ext) {
                return ext.match(/(htm|html)$/i);
            },
            'txt': function(ext) {
                return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            },
            'mov': function(ext) {
                return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            },
            'mp3': function(ext) {
                return ext.match(/(mp3|wav)$/i);
            },
        },
        fileActionSettings: {
            dragIcon: '<i class="fas fa-arrows-alt-v"></i>',
            showUpload: false,
        },
        allowedFileExtensions: [
            'jpg',
            'jpeg',
            'gif',
            'png',
        ],
        maxFileCount: 1,
    }).on('filebatchselected', function(e, files) {
        if (Object.keys(files).length > 0) {
            $photo_file_upload_btn.show();
        }
    }).on('filepreremove', function(event, id, index) {
        let current_selected_files = $('#photo-file-input').fileinput('getFileStack');
        if (Object.keys(current_selected_files).length === 1) {
            $photo_file_upload_btn.fadeOut('slow');
        }
    }).on('fileuploaded', function(e, params) {
        $photo_file_upload_btn.hide();
        let file_data = ($('#photo-file-hidden').val() != '') ? JSON.parse($('#photo-file-hidden').val()) : [];
        file_data[file_data.length] = {
            key: params.response.key,
            size: params.response.size,
            cur_name: params.response.cur_name,
            org_name: params.response.org_name,
            delete_url: params.response.delete_url,
        };
        $('#photo-file-hidden').val(JSON.stringify(file_data));
    }).on('filedeleted', function(e, key, jqXHR, data) {
        let file_data = ($('#photo-file-hidden').val() != '') ? JSON.parse($('#photo-file-hidden').val()) : [];
        let delete_index = file_data.findIndex((v) => v.cur_name === key);
        if (delete_index > -1) {
            file_data.splice(delete_index, 1);
        }
        $('#photo-file-hidden').val(JSON.stringify(file_data));
    }).on('filesorted', function(e, params) {
        let file_data = [];
        params.stack.forEach(function(item) {
            file_data.push({
                key: item.key,
                size: item.size,
                cur_name: item.key,
                org_name: item.caption,
                delete_url: item.url,
            });
        });
        $('#photo-file-hidden').val(JSON.stringify(file_data));
    });
    var $photo_file_upload_btn = $("#photo-file-input").parents('.input-group').find('.fileinput-upload-button');
    $photo_file_upload_btn.hide();

});
