<?php
use Migrations\AbstractSeed;

/**
 * ChargeRelations seed.
 */
class ChargeRelationsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'charge_id' => '1',
                'charge_master_id' => '1',
                'search_snippet' => '基本プラン ',
                'created' => '2020-05-02 08:15:15',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '2',
                'charge_id' => '2',
                'charge_master_id' => '2',
                'search_snippet' => '特別プランＡコース Ａ-1コース',
                'created' => '2020-05-02 08:15:26',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '3',
                'charge_id' => '2',
                'charge_master_id' => '3',
                'search_snippet' => '特別プランＡコース Ａ-2コース',
                'created' => '2020-05-02 08:15:32',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '4',
                'charge_id' => '2',
                'charge_master_id' => '4',
                'search_snippet' => '特別プランＡコース Ａ-3コース',
                'created' => '2020-05-02 08:16:41',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '5',
                'charge_id' => '3',
                'charge_master_id' => '5',
                'search_snippet' => '特別プランＢコース Ｂ-1コース',
                'created' => '2020-05-02 08:16:49',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '6',
                'charge_id' => '3',
                'charge_master_id' => '6',
                'search_snippet' => '特別プランＢコース Ｂ-2コース',
                'created' => '2020-05-02 08:16:55',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '7',
                'charge_id' => '4',
                'charge_master_id' => '7',
                'search_snippet' => 'おすすめプラン おすすめ１',
                'created' => '2020-05-02 08:17:05',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '8',
                'charge_id' => '4',
                'charge_master_id' => '8',
                'search_snippet' => 'おすすめプラン おすすめ２',
                'created' => '2020-05-02 08:17:12',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '9',
                'charge_id' => '4',
                'charge_master_id' => '9',
                'search_snippet' => 'おすすめプラン おすすめ３',
                'created' => '2020-05-02 08:17:18',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '10',
                'charge_id' => '5',
                'charge_master_id' => '10',
                'search_snippet' => 'その他 その他１',
                'created' => '2020-05-02 08:17:25',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
            [
                'id' => '11',
                'charge_id' => '5',
                'charge_master_id' => '11',
                'search_snippet' => 'その他 その他２',
                'created' => '2020-05-02 08:17:32',
                'modified' => '2020-09-30 15:26:40',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('charge_relations');
        $table->truncate();
        $table->insert($data)->save();
    }
}
