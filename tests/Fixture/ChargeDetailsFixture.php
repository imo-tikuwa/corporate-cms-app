<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChargeDetailsFixture
 */
class ChargeDetailsFixture extends TestFixture
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
            'comment' => '',
            'autoIncrement' => true,
            'precision' => null,
        ],
        'charge_id' => [
            'type' => 'integer',
            'length' => null,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '料金ID',
            'precision' => null,
            'autoIncrement' => null,
        ],
        'name' => [
            'type' => 'string',
            'length' => 255,
            'null' => true,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '料金名',
            'precision' => null,
        ],
        'basic_charge' => [
            'type' => 'integer',
            'length' => null,
            'unsigned' => false,
            'null' => true,
            'default' => null,
            'comment' => '基本料金',
            'precision' => null,
            'autoIncrement' => null,
        ],
        'campaign_charge' => [
            'type' => 'integer',
            'length' => null,
            'unsigned' => false,
            'null' => true,
            'default' => null,
            'comment' => 'キャンペーン料金',
            'precision' => null,
            'autoIncrement' => null,
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
        '_indexes' => [
            'charge_id' => [
                'type' => 'index',
                'columns' => [
                    'charge_id',
                ],
                'length' => [
                ],
            ],
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
                'charge_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'basic_charge' => 0,
                'campaign_charge' => 0,
                'created' => '2021-04-01 19:57:28',
                'modified' => '2021-04-01 19:57:28',
                'deleted' => null,
            ],
        ];
        parent::init();
    }
}
