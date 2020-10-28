<?php
use Migrations\AbstractSeed;

/**
 * OperationLogsHourly seed.
 */
class OperationLogsHourlySeed extends AbstractSeed
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
        ];

        $table = $this->table('operation_logs_hourly');
        $table->truncate();
        $table->insert($data)->save();
    }
}
