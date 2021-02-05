<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StaffsFixture
 */
class StaffsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    public $fields = [
        'id' => [
            'type' => 'integer',
            'length' => null,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => 'ID',
            'autoIncrement' => true,
            'precision' => null,
        ],
        'name' => [
            'type' => 'string',
            'length' => 255,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'スタッフ名',
            'precision' => null,
        ],
        'name_en' => [
            'type' => 'string',
            'length' => 255,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'スタッフ名(英)',
            'precision' => null,
        ],
        'staff_position' => [
            'type' => 'char',
            'length' => 2,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'スタッフ役職',
            'precision' => null,
        ],
        'photo_position' => [
            'type' => 'char',
            'length' => 2,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '画像表示位置',
            'precision' => null,
        ],
        'photo' => [
            'type' => 'json',
            'length' => null,
            'null' => true,
            'default' => null,
            'comment' => 'スタッフ画像',
            'precision' => null,
        ],
        'description1' => [
            'type' => 'text',
            'length' => null,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'スタッフ説明1',
            'precision' => null,
        ],
        'midashi1' => [
            'type' => 'string',
            'length' => 255,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '見出し1',
            'precision' => null,
        ],
        'description2' => [
            'type' => 'text',
            'length' => null,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'スタッフ説明2',
            'precision' => null,
        ],
        'search_snippet' => [
            'type' => 'text',
            'length' => 16777215,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => 'フリーワード検索用のスニペット',
            'precision' => null,
        ],
        'created' => [
            'type' => 'datetime',
            'length' => null,
            'precision' => null,
            'null' => true,
            'default' => null,
            'comment' => '作成日時',
        ],
        'modified' => [
            'type' => 'datetime',
            'length' => null,
            'precision' => null,
            'null' => true,
            'default' => null,
            'comment' => '更新日時',
        ],
        'deleted' => [
            'type' => 'datetime',
            'length' => null,
            'precision' => null,
            'null' => true,
            'default' => null,
            'comment' => '削除日時',
        ],
        '_constraints' => [
            'primary' => [
                'type' => 'primary',
                'columns' => [
                    'id',
                ],
                'length' => [
                ],
            ],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci',
        ],
    ];

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'name_en' => 'Lorem ipsum dolor sit amet',
                'staff_position' => '01',
                'photo_position' => '01',
                'photo' => [
                    0 => [
                        'key' => '9288ac73e78f44b37f81596ed38eb0f27da6f7bd.jpg',
                        'size' => 775702,
                        'cur_name' => '9288ac73e78f44b37f81596ed38eb0f27da6f7bd.jpg',
                        'org_name' => 'Test.jpg',
                        'delete_url' => '/admin/staffs/file-delete/photo_file',
                    ],
                ],
                'description1' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'midashi1' => 'Lorem ipsum dolor sit amet',
                'description2' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'search_snippet' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2021-02-04 22:47:02',
                'modified' => '2021-02-04 22:47:02',
                'deleted' => null,
            ],
        ];
        parent::init();
    }
}
