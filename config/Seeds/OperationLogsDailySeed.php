<?php
use Migrations\AbstractSeed;

/**
 * OperationLogsDaily seed.
 */
class OperationLogsDailySeed extends AbstractSeed
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

        $table = $this->table('operation_logs_daily');
        $table->truncate();
        $table->insert($data)->save();
    }
}
