<?php
use Migrations\AbstractSeed;

/**
 * Admins seed.
 */
class AdminsSeed extends AbstractSeed
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
                'mail' => 'admin@imo-tikuwa.com',
                'password' => 'bVyZaKyAReRheTgNqzWYdg==:xzWJqEcUZpCaEMSsSL782Q==',
                'privilege' => NULL,
                'created' => '2020-10-07 19:00:52',
                'modified' => '2020-10-07 19:00:52',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('admins');
        $table->truncate();
        $table->insert($data)->save();
    }
}
