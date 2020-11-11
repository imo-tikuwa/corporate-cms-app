<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Staffs seed.
 */
class StaffsSeed extends AbstractSeed
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
                'name' => '山田花子',
                'name_en' => 'Hanako Yamada',
                'staff_position' => '01',
                'photo_position' => '02',
                'photo' => '[{"key": "b978c5002f0e45f0a4be3b1453fea7610a049e2b.jpg", "size": 777835, "cur_name": "b978c5002f0e45f0a4be3b1453fea7610a049e2b.jpg", "org_name": "Penguins.jpg", "delete_url": "/admin/staffs/fileDelete/photo_file"}]',
                'description1' => 'イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。
イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。',
                'midashi1' => '',
                'description2' => '<ul class="list">
<li>校正用サンプルリストです。任意のテキストに置き換えてお使いください。</li>
<li>校正用サンプルリストです。任意のテキストに置き換えてお使いください。</li>
<li>校正用サンプルリストです。任意のテキストに置き換えてお使いください。</li>
<li>校正用サンプルリストです。任意のテキストに置き換えてお使いください。</li>
<li>校正用サンプルリストです。任意のテキストに置き換えてお使いください。</li>
</ul>',
                'search_snippet' => '山田花子 Hanako Yamada スタイリスト 右 イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。
イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。  
校正用サンプルリストです。任意のテキストに置き換えてお使いください。
校正用サンプルリストです。任意のテキストに置き換えてお使いください。
校正用サンプルリストです。任意のテキストに置き換えてお使いください。
校正用サンプルリストです。任意のテキストに置き換えてお使いください。
校正用サンプルリストです。任意のテキストに置き換えてお使いください。
',
                'created' => '2020-05-01 20:38:07',
                'modified' => '2020-09-30 15:26:52',
                'deleted' => NULL,
            ],
            [
                'id' => '2',
                'name' => '山田太郎',
                'name_en' => 'Taro Yamada',
                'staff_position' => '01',
                'photo_position' => '01',
                'photo' => '[{"key": "b867f7f0fd9d7eadb239079b67372a86521154ec.jpg", "size": 780831, "cur_name": "b867f7f0fd9d7eadb239079b67372a86521154ec.jpg", "org_name": "Koala.jpg", "delete_url": "/admin/staffs/fileDelete/photo_file"}]',
                'description1' => 'イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。',
                'midashi1' => '校正用サンプル小見出し<span>H4サンプル小見出し</span>',
                'description2' => 'イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。',
                'search_snippet' => '山田太郎 Taro Yamada スタイリスト 左 イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。 校正用サンプル小見出し<span>H4サンプル小見出し</span> イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。',
                'created' => '2020-05-01 20:43:20',
                'modified' => '2020-09-30 15:26:52',
                'deleted' => NULL,
            ],
            [
                'id' => '3',
                'name' => '鈴木一郎',
                'name_en' => 'Ichiro Suzuki',
                'staff_position' => '02',
                'photo_position' => '02',
                'photo' => '[{"key": "eac5d8c230f207d63f1881aa7890c2e074559dc5.jpg", "size": 775702, "cur_name": "eac5d8c230f207d63f1881aa7890c2e074559dc5.jpg", "org_name": "Jellyfish.jpg", "delete_url": "/admin/staffs/fileDelete/photo_file"}]',
                'description1' => 'イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。',
                'midashi1' => '',
                'description2' => '',
                'search_snippet' => '鈴木一郎 Ichiro Suzuki アシスタント 右 イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。

意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。  ',
                'created' => '2020-05-01 20:44:19',
                'modified' => '2020-09-30 15:26:52',
                'deleted' => NULL,
            ],
        ];

        $table = $this->table('staffs');
        $table->insert($data)->save();
    }
}
