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
        'Charges' => '料金',
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
        ],
        'Staffs' => [
            'controller' => 'Staffs',
            'label' => 'スタッフ',
            'icon_class' => 'fas fa-users',
        ],
        'Charges' => [
            'controller' => 'Charges',
            'label' => '料金',
            'icon_class' => 'fas fa-yen-sign',
        ],
        'AccessMaps' => [
            'controller' => 'AccessMaps',
            'label' => 'アクセスマップ',
            'icon_class' => 'fas fa-map-marked-alt',
        ],
        'Contacts' => [
            'controller' => 'Contacts',
            'label' => 'お問い合わせ情報',
            'icon_class' => 'fas fa-question',
        ],
    ],
    'FileUploadOptions' => [
        'Staffs' => [
            'photo_file' => [
                'max_file_num' => 1,
                'allow_file_extensions' => [
                    0 => 'jpg',
                    1 => 'jpeg',
                    2 => 'gif',
                    3 => 'png',
                ],
                'create_thumbnail' => true,
                'thumbnail_width' => 180,
                'thumbnail_height' => 120,
                'thumbnail_aspect_ratio_keep' => true,
                'thumbnail_quality' => 99,
            ],
        ],
    ],
    'ExcelOptions' => [
        'Charges' => [
            'version' => '4ebadae4534ef2d502226be3dc12bdd1d2ff13d3b9a1ce9d134a58717d9fcb886e450b29fa53be1d43ec40838cdd35c1eab634cb32163d7b85c799eb0bc170b8',
        ],
        'Contacts' => [
            'version' => 'da3f2f085b89ff15a8351120da19a463b103f523107eed2ebdbe27107fd7ffe72042b143b616ce40487bcd3e353b18cec8491f68b71eabc09800309e55225c7b',
        ],
        'Links' => [
            'version' => '1b264f278aef7f064260e448911e4b16f07e1c5efaa8183245389c5ab7d67bd5ca44385f6d4799105243a1243c43b56a2a78666a86d0dfd40421f007d6e3a4ea',
        ],
        'Staffs' => [
            'version' => '56f71fda424a6022ce654210e32bf4e4dbb1cb041d089a86e4049bdf1c2eed56fd1f9e646d4c8f1ddc89007ef77ea10cb9e4afaf06ee31941402956dca5aa6c5',
        ],
    ],
    'InitialOrders' => [
        'AccessMaps' => [
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
        'Charges' => [
            ROLE_READ => '料金読込',
            ROLE_WRITE => '料金書込',
            ROLE_DELETE => '料金削除',
            ROLE_CSV_EXPORT => '料金CSVエクスポート',
            ROLE_EXCEL_EXPORT => '料金Excelエクスポート',
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
