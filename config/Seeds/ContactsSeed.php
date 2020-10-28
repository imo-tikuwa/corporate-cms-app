<?php
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
     * http://docs.phinx.org/en/latest/seeding.html
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
        ];

        $table = $this->table('contacts');
        $table->truncate();
        $table->insert($data)->save();
    }
}
