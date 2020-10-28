<?php
use Migrations\AbstractSeed;

/**
 * ChargeMasters seed.
 */
class ChargeMastersSeed extends AbstractSeed
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
                'name' => '',
                'basic_charge' => '5250',
                'campaign_charge' => '4200',
                'search_snippet' => NULL,
                'created' => '2020-05-01 21:07:19',
                'modified' => '2020-05-01 21:07:19',
                'deleted' => NULL,
            ],
            [
                'id' => '2',
                'name' => 'Ａ-1コース',
                'basic_charge' => '8400',
                'campaign_charge' => '6300',
                'search_snippet' => 'Ａ-1コース',
                'created' => '2020-05-01 21:07:35',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '3',
                'name' => 'Ａ-2コース',
                'basic_charge' => '16800',
                'campaign_charge' => '12600',
                'search_snippet' => 'Ａ-2コース',
                'created' => '2020-05-01 21:07:47',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '4',
                'name' => 'Ａ-3コース',
                'basic_charge' => '18900',
                'campaign_charge' => '14700',
                'search_snippet' => 'Ａ-3コース',
                'created' => '2020-05-01 21:08:05',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '5',
                'name' => 'Ｂ-1コース',
                'basic_charge' => '8400',
                'campaign_charge' => '6300',
                'search_snippet' => 'Ｂ-1コース',
                'created' => '2020-05-01 21:08:21',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '6',
                'name' => 'Ｂ-2コース',
                'basic_charge' => '16800',
                'campaign_charge' => '12600',
                'search_snippet' => 'Ｂ-2コース',
                'created' => '2020-05-01 21:08:33',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '7',
                'name' => 'おすすめ１',
                'basic_charge' => '6300',
                'campaign_charge' => '5250',
                'search_snippet' => 'おすすめ１',
                'created' => '2020-05-01 21:08:47',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '8',
                'name' => 'おすすめ２',
                'basic_charge' => '8400',
                'campaign_charge' => '6300',
                'search_snippet' => 'おすすめ２',
                'created' => '2020-05-01 21:08:59',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '9',
                'name' => 'おすすめ３',
                'basic_charge' => '10500',
                'campaign_charge' => '8400',
                'search_snippet' => 'おすすめ３',
                'created' => '2020-05-01 21:09:13',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '10',
                'name' => 'その他１',
                'basic_charge' => '3150',
                'campaign_charge' => '2100',
                'search_snippet' => 'その他１',
                'created' => '2020-05-01 21:09:30',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '11',
                'name' => 'その他２',
                'basic_charge' => '4200',
                'campaign_charge' => '2750',
                'search_snippet' => 'その他２',
                'created' => '2020-05-01 21:09:57',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('charge_masters');
        $table->truncate();
        $table->insert($data)->save();
    }
}
