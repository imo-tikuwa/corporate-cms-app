<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Charges seed.
 */
class ChargesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => '基本プラン',
                'annotation' => '　',
                'search_snippet' => '基本プラン ',
                'created' => '2020-05-01 21:12:28',
                'modified' => '2020-09-30 15:26:33',
                'deleted' => NULL,
            ],
            [
                'id' => '2',
                'name' => '特別プランＡコース',
                'annotation' => '（注釈サンプル）',
                'search_snippet' => '特別プランＡコース （注釈サンプル）',
                'created' => '2020-05-01 21:12:42',
                'modified' => '2020-09-30 15:26:33',
                'deleted' => NULL,
            ],
            [
                'id' => '3',
                'name' => '特別プランＢコース',
                'annotation' => '（注釈サンプル）',
                'search_snippet' => '特別プランＢコース （注釈サンプル）',
                'created' => '2020-05-01 21:12:51',
                'modified' => '2020-09-30 15:26:33',
                'deleted' => NULL,
            ],
            [
                'id' => '4',
                'name' => 'おすすめプラン',
                'annotation' => '',
                'search_snippet' => 'おすすめプラン ',
                'created' => '2020-05-01 21:12:56',
                'modified' => '2020-09-30 15:26:33',
                'deleted' => NULL,
            ],
            [
                'id' => '5',
                'name' => 'その他',
                'annotation' => '',
                'search_snippet' => 'その他 ',
                'created' => '2020-05-01 21:13:03',
                'modified' => '2020-09-30 15:26:33',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('charges');
        $table->insert($data)->save();
    }
}
