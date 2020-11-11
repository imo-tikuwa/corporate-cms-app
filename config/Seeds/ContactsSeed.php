<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Contacts seed.
 */
class ContactsSeed extends AbstractSeed
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
                'name' => '問い合わせゆーざー１',
                'email' => 'contact1@imo-tikuwa.com',
                'type' => '01',
                'tel' => '080-0000-0000',
                'content' => '問い合わせほげほげ
問い合わせふがふが',
                'hp_url' => '',
                'search_snippet' => '問い合わせゆーざー１ contact1@imo-tikuwa.com ご予約 080-0000-0000 問い合わせほげほげ
問い合わせふがふが ',
                'created' => '2020-05-02 12:19:43',
                'modified' => '2020-09-30 15:27:24',
                'deleted' => NULL,
            ],
            [
                'id' => '2',
                'name' => '問い合わせゆーざー２',
                'email' => 'contact2@imo-tikuwa.com',
                'type' => '02',
                'tel' => '',
                'content' => 'memomemo',
                'hp_url' => 'https://www.yahoo.co.jp/',
                'search_snippet' => '問い合わせゆーざー２ contact2@imo-tikuwa.com その他お問い合わせ  memomemo https://www.yahoo.co.jp/',
                'created' => '2020-05-02 12:20:31',
                'modified' => '2020-09-30 15:27:24',
                'deleted' => NULL,
            ],
            [
                'id' => '3',
                'name' => '問い合わせテスト',
                'email' => 'hogehoge@imo-tikuwa.com',
                'type' => '01',
                'tel' => '',
                'content' => 'CakePHP4アップデートした',
                'hp_url' => 'http://',
                'search_snippet' => '問い合わせテスト hogehoge@imo-tikuwa.com ご予約  CakePHP4アップデートした http://',
                'created' => '2020-10-12 20:26:28',
                'modified' => '2020-10-12 20:26:28',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('contacts');
        $table->insert($data)->save();
    }
}
