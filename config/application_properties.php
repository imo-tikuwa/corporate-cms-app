<?php
return [
    'SystemProperties' => [
        'RoleList' => [
            0 => ROLE_READ,
            1 => ROLE_WRITE,
            2 => ROLE_DELETE,
            3 => ROLE_CSV_EXPORT,
            4 => ROLE_CSV_IMPORT,
            5 => ROLE_EXCEL_EXPORT,
            6 => ROLE_EXCEL_IMPORT,
        ],
        'RoleBadgeClass' => [
            ROLE_READ => 'badge badge-primary',
            ROLE_WRITE => 'badge badge-danger',
            ROLE_DELETE => 'badge badge-warning text-white',
            ROLE_CSV_EXPORT => 'badge badge-info',
            ROLE_CSV_IMPORT => 'badge badge-success',
            ROLE_EXCEL_EXPORT => 'badge badge-info',
            ROLE_EXCEL_IMPORT => 'badge badge-success',
        ],
    ],
    'BakedFunctions' => [
        'AccessMaps' => 'アクセスマップ',
        'ChargeMasters' => '料金マスタ',
        'ChargeRelations' => '料金マッピング',
        'Charges' => '基本料金',
        'Contacts' => 'お問い合わせ情報',
        'Links' => 'リンク集',
        'Staffs' => 'スタッフ',
    ],
    'Codes' => [
        'Contacts' => [
            'type' => [
                '01' => 'ご予約',
                '02' => 'その他お問い合わせ',
            ],
        ],
        'Links' => [
            'category' => [
                '01' => 'ショップ関連',
                '02' => 'その他',
            ],
        ],
        'Staffs' => [
            'staff_position' => [
                '01' => 'スタイリスト',
                '02' => 'アシスタント',
            ],
            'photo_position' => [
                '01' => '左',
                '02' => '右',
            ],
        ],
    ],
    'HeaderConfig' => [
        1 => [
            'title' => 'Yahoo! JAPAN',
            'link' => 'https://yahoo.co.jp/',
        ],
        2 => [
            'title' => 'Google',
            'link' => 'https://www.google.com/',
        ],
    ],
    'FooterConfig' => [
        'buttons' => [
            1 => [
                'button_text' => 'BLOG',
                'button_icon' => 'fas fa-user',
                'button_link' => 'https://blog.imo-tikuwa.com/',
            ],
            2 => [
                'button_text' => 'GitHub',
                'button_icon' => 'fab fa-github',
                'button_link' => 'https://github.com/imo-tikuwa/',
            ],
        ],
        'copylight' => [
            'from' => '2020',
            'text' => 'CorporateCMS',
            'link' => 'https://github.com/imo-tikuwa/corporate-cms',
        ],
    ],
    'LeftSideMenu' => [
        'Links' => [
            'controller' => 'Links',
            'label' => 'リンク集',
            'icon_class' => 'fas fa-external-link-alt',
            'one_record_limited' => false,
        ],
        'Staffs' => [
            'controller' => 'Staffs',
            'label' => 'スタッフ',
            'icon_class' => 'fas fa-users',
            'one_record_limited' => false,
        ],
        'ChargeMasters' => [
            'controller' => 'ChargeMasters',
            'label' => '料金マスタ',
            'icon_class' => 'fas fa-yen-sign',
            'one_record_limited' => false,
        ],
        'Charges' => [
            'controller' => 'Charges',
            'label' => '基本料金',
            'icon_class' => 'fas fa-yen-sign',
            'one_record_limited' => false,
        ],
        'ChargeRelations' => [
            'controller' => 'ChargeRelations',
            'label' => '料金マッピング',
            'icon_class' => 'fas fa-arrows-alt-h',
            'one_record_limited' => false,
        ],
        'AccessMaps' => [
            'controller' => 'AccessMaps',
            'label' => 'アクセスマップ',
            'icon_class' => 'fas fa-map-marked-alt',
            'one_record_limited' => true,
        ],
        'Contacts' => [
            'controller' => 'Contacts',
            'label' => 'お問い合わせ情報',
            'icon_class' => 'fas fa-question',
            'one_record_limited' => false,
        ],
    ],
    'ThumbnailOptions' => [
        'Staffs' => [
            'photo_file' => [
                'thumbnail_width' => 180,
                'thumbnail_height' => 120,
                'thumbnail_aspect_ratio_keep' => true,
                'thumbnail_quality' => 99,
            ],
        ],
    ],
    'ExcelOptions' => [
        'Charges' => [
            'version' => 'b25b294cb4deb69ea00a4c3cf3113904801b6015e5956bd019a8570b1fe1d6040e944ef3cdee16d0a46503ca6e659a25f21cf9ceddc13f352a3c98138c15d6af',
        ],
        'Contacts' => [
            'version' => 'a9b7d31e3124d1adecfe214becca4b0055420bc1746a940247751427d44aa90b24002dbec319ee33ef3835bf0a5d69d878785a5d276c689182b4c832a9703083',
        ],
        'Links' => [
            'version' => '0f92b960b5c30cae9190fa500cb84e0b706f82609da69a143c9540f292a8b2d7ce8b1605b246a8dd31f4a6d91d7b0cc6fcd4a759a8ecbd3480306dea29a26b2d',
        ],
        'Staffs' => [
            'version' => 'e0147c452c5c0fc01371e1659b3a04a59c6ad66f2f3011deee6f559c2353c829f1abae9c8fe05b17567249e06be74906c4ae4f850a78b7a4605b71ef3ff12f1b',
        ],
    ],
    'InitialOrders' => [
        'AccessMaps' => [
            'sort' => 'id',
            'direction' => 'asc',
        ],
        'ChargeMasters' => [
            'sort' => 'id',
            'direction' => 'asc',
        ],
        'ChargeRelations' => [
            'sort' => 'id',
            'direction' => 'asc',
        ],
        'Charges' => [
            'sort' => 'id',
            'direction' => 'asc',
        ],
        'Contacts' => [
            'sort' => 'created',
            'direction' => 'desc',
        ],
        'Links' => [
            'sort' => 'id',
            'direction' => 'asc',
        ],
        'Staffs' => [
            'sort' => 'id',
            'direction' => 'asc',
        ],
    ],
    'AdminRoles' => [
        'Links' => [
            ROLE_READ => 'リンク集読込',
            ROLE_WRITE => 'リンク集書込',
            ROLE_DELETE => 'リンク集削除',
            ROLE_CSV_EXPORT => 'リンク集CSVエクスポート',
            ROLE_CSV_IMPORT => 'リンク集CSVインポート',
            ROLE_EXCEL_EXPORT => 'リンク集Excelエクスポート',
            ROLE_EXCEL_IMPORT => 'リンク集Excelインポート',
        ],
        'Staffs' => [
            ROLE_READ => 'スタッフ読込',
            ROLE_WRITE => 'スタッフ書込',
            ROLE_DELETE => 'スタッフ削除',
            ROLE_CSV_EXPORT => 'スタッフCSVエクスポート',
            ROLE_EXCEL_EXPORT => 'スタッフExcelエクスポート',
        ],
        'ChargeMasters' => [
            ROLE_READ => '料金マスタ読込',
            ROLE_WRITE => '料金マスタ書込',
            ROLE_DELETE => '料金マスタ削除',
            ROLE_CSV_EXPORT => '料金マスタCSVエクスポート',
        ],
        'Charges' => [
            ROLE_READ => '基本料金読込',
            ROLE_WRITE => '基本料金書込',
            ROLE_DELETE => '基本料金削除',
            ROLE_CSV_EXPORT => '基本料金CSVエクスポート',
            ROLE_EXCEL_EXPORT => '基本料金Excelエクスポート',
        ],
        'ChargeRelations' => [
            ROLE_READ => '料金マッピング読込',
            ROLE_WRITE => '料金マッピング書込',
            ROLE_DELETE => '料金マッピング削除',
            ROLE_CSV_EXPORT => '料金マッピングCSVエクスポート',
        ],
        'AccessMaps' => [
            ROLE_WRITE => 'アクセスマップ書込',
        ],
        'Contacts' => [
            ROLE_READ => 'お問い合わせ情報読込',
            ROLE_WRITE => 'お問い合わせ情報書込',
            ROLE_DELETE => 'お問い合わせ情報削除',
            ROLE_CSV_EXPORT => 'お問い合わせ情報CSVエクスポート',
            ROLE_EXCEL_EXPORT => 'お問い合わせ情報Excelエクスポート',
        ],
    ],
    'Others' => [
        'search_snippet_format' => [
            'AND' => ' AND',
            'OR' => ' OR',
        ],
    ],
];
