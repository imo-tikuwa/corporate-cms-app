<?php
use Migrations\AbstractSeed;

/**
 * Phinxlog seed.
 */
class PhinxlogSeed extends AbstractSeed
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
                'version' => '20200501114600',
                'migration_name' => 'Initial',
                'start_time' => '2020-05-01 11:46:01',
                'end_time' => '2020-05-01 11:46:01',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200501121715',
                'migration_name' => 'Initial',
                'start_time' => '2020-05-01 12:17:16',
                'end_time' => '2020-05-01 12:17:16',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200501131841',
                'migration_name' => 'Initial',
                'start_time' => '2020-05-01 13:18:41',
                'end_time' => '2020-05-01 13:18:41',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200501231840',
                'migration_name' => 'Initial',
                'start_time' => '2020-05-01 23:18:41',
                'end_time' => '2020-05-01 23:18:41',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200502032108',
                'migration_name' => 'Initial',
                'start_time' => '2020-05-02 03:21:09',
                'end_time' => '2020-05-02 03:21:09',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200530061929',
                'migration_name' => 'Initial',
                'start_time' => '2020-05-30 06:19:31',
                'end_time' => '2020-05-30 06:19:31',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200804234150',
                'migration_name' => 'Initial',
                'start_time' => '2020-08-04 23:41:51',
                'end_time' => '2020-08-04 23:41:51',
                'breakpoint' => '0',
            ],
            [
                'version' => '20200930071811',
                'migration_name' => 'Initial',
                'start_time' => '2020-09-30 07:18:12',
                'end_time' => '2020-09-30 07:18:12',
                'breakpoint' => '0',
            ],
            [
                'version' => '20201007094517',
                'migration_name' => 'Initial',
                'start_time' => '2020-10-07 09:45:18',
                'end_time' => '2020-10-07 09:45:18',
                'breakpoint' => '0',
            ],
            [
                'version' => '20201007095003',
                'migration_name' => 'Initial',
                'start_time' => '2020-10-07 09:50:03',
                'end_time' => '2020-10-07 09:50:03',
                'breakpoint' => '0',
            ],
            [
                'version' => '20201007100354',
                'migration_name' => 'Initial',
                'start_time' => '2020-10-07 10:03:54',
                'end_time' => '2020-10-07 10:03:54',
                'breakpoint' => '0',
            ],
        ];

        $table = $this->table('phinxlog');
        $table->truncate();
        $table->insert($data)->save();
    }
}
