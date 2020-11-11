<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * AccessMaps seed.
 */
class AccessMapsSeed extends AbstractSeed
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
                'description' => 'ＪＲ見本線サンプル駅西口下車、徒歩５分。',
                'location' => '{"zoom": 16, "latitude": 35.746945044896, "longitude": 139.80781693825}',
                'map_link' => 'https://www.google.co.jp/maps/@35.7478139,139.8086136,17z?hl=ja',
                'created' => '2020-05-01 22:05:18',
                'modified' => '2020-06-28 10:00:12',
            ],
        ];

        $table = $this->table('access_maps');
        $table->insert($data)->save();
    }
}
