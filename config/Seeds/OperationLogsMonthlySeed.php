<?php
use Migrations\AbstractSeed;

/**
 * OperationLogsMonthly seed.
 */
class OperationLogsMonthlySeed extends AbstractSeed
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

        $table = $this->table('operation_logs_monthly');
        $table->truncate();
        $table->insert($data)->save();
    }
}
