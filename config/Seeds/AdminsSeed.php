<?php
declare(strict_types=1);

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
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => '',
                'mail' => 'admin@imo-tikuwa.com',
                'password' => 'bVyZaKyAReRheTgNqzWYdg==:xzWJqEcUZpCaEMSsSL782Q==',
                'use_otp' => '0',
                'otp_secret' => NULL,
                'privilege' => NULL,
                'created' => '2020-10-07 19:00:52',
                'modified' => '2020-10-07 19:00:52',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('admins');
        $table->insert($data)->save();
    }
}
