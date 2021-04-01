<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * ChargeDetails seed.
 */
class ChargeDetailsSeed extends AbstractSeed
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
                'charge_id' => '1',
                'name' => '',
                'basic_charge' => '5250',
                'campaign_charge' => '4200',
                'created' => '2020-05-01 21:07:19',
                'modified' => '2020-05-01 21:07:19',
                'deleted' => NULL,
            ],
            [
                'id' => '2',
                'charge_id' => '2',
                'name' => 'Ａ-1コース',
                'basic_charge' => '8400',
                'campaign_charge' => '6300',
                'created' => '2020-05-01 21:07:35',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '3',
                'charge_id' => '2',
                'name' => 'Ａ-2コース',
                'basic_charge' => '16800',
                'campaign_charge' => '12600',
                'created' => '2020-05-01 21:07:47',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '4',
                'charge_id' => '2',
                'name' => 'Ａ-3コース',
                'basic_charge' => '18900',
                'campaign_charge' => '14700',
                'created' => '2020-05-01 21:08:05',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '5',
                'charge_id' => '3',
                'name' => 'Ｂ-1コース',
                'basic_charge' => '8400',
                'campaign_charge' => '6300',
                'created' => '2020-05-01 21:08:21',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '6',
                'charge_id' => '3',
                'name' => 'Ｂ-2コース',
                'basic_charge' => '16800',
                'campaign_charge' => '12600',
                'created' => '2020-05-01 21:08:33',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '7',
                'charge_id' => '4',
                'name' => 'おすすめ１',
                'basic_charge' => '6300',
                'campaign_charge' => '5250',
                'created' => '2020-05-01 21:08:47',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '8',
                'charge_id' => '4',
                'name' => 'おすすめ２',
                'basic_charge' => '8400',
                'campaign_charge' => '6300',
                'created' => '2020-05-01 21:08:59',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '9',
                'charge_id' => '4',
                'name' => 'おすすめ３',
                'basic_charge' => '10500',
                'campaign_charge' => '8400',
                'created' => '2020-05-01 21:09:13',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '10',
                'charge_id' => '5',
                'name' => 'その他１',
                'basic_charge' => '3150',
                'campaign_charge' => '2100',
                'created' => '2020-05-01 21:09:30',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
            [
                'id' => '11',
                'charge_id' => '5',
                'name' => 'その他２',
                'basic_charge' => '4200',
                'campaign_charge' => '2750',
                'created' => '2020-05-01 21:09:57',
                'modified' => '2020-09-30 15:26:45',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('charge_details');
        $table->insert($data)->save();
    }
}
