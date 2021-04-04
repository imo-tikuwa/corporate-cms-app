<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public $autoId = false;

    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        $this->table('access_maps', [
                'comment' => 'アクセスマップ',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('description', 'string', [
                'comment' => 'アクセス方法',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('location', 'json', [
                'comment' => 'GoogleMap地図座標',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('map_link', 'text', [
                'comment' => '地図リンク',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('admins', [
                'comment' => '管理者情報',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'comment' => '名前',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('mail', 'string', [
                'comment' => 'メールアドレス',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'comment' => 'パスワード',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('use_otp', 'boolean', [
                'comment' => '二段階認証を使用する？',
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('otp_secret', 'string', [
                'comment' => '二段階認証用シークレットキー',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('privilege', 'json', [
                'comment' => '権限',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('charge_details', [
                'comment' => '料金 - 料金詳細',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('charge_id', 'integer', [
                'comment' => '料金ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'comment' => '料金名',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('basic_charge', 'integer', [
                'comment' => '基本料金',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('campaign_charge', 'integer', [
                'comment' => 'キャンペーン料金',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'charge_id',
                ]
            )
            ->create();

        $this->table('charges', [
                'comment' => '料金',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'comment' => 'プラン名',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('annotation', 'string', [
                'comment' => 'プラン名下注釈',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('search_snippet', 'text', [
                'comment' => 'フリーワード検索用のスニペット',
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('contacts', [
                'comment' => 'お問い合わせ情報',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'comment' => 'お名前',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'comment' => 'メールアドレス',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('type', 'char', [
                'comment' => 'お問い合わせ内容',
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('tel', 'string', [
                'comment' => 'お電話番号',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('content', 'text', [
                'comment' => 'ご希望日時／その他ご要望等',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('hp_url', 'string', [
                'comment' => 'ホームページURL',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('search_snippet', 'text', [
                'comment' => 'フリーワード検索用のスニペット',
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('links', [
                'comment' => 'リンク集',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('category', 'char', [
                'comment' => 'リンクカテゴリ',
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'comment' => 'リンクタイトル',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'comment' => 'リンクURL',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'comment' => 'リンク説明',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('search_snippet', 'text', [
                'comment' => 'フリーワード検索用のスニペット',
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('operation_logs', [
                'comment' => '操作ログ',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('client_ip', 'text', [
                'comment' => 'クライアントIP',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_agent', 'text', [
                'comment' => 'ユーザーエージェント',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('request_url', 'string', [
                'comment' => 'リクエストURL',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('request_time', 'datetime', [
                'comment' => 'リクエスト日時',
                'default' => null,
                'limit' => null,
                'null' => false,
                'precision' => 3,
                // 'scale' => 3
            ])
            ->addColumn('response_time', 'datetime', [
                'comment' => 'レスポンス日時',
                'default' => null,
                'limit' => null,
                'null' => false,
                'precision' => 3,
                // 'scale' => 3
            ])
            ->create();

        $this->table('operation_logs_daily', [
                'comment' => '操作ログの集計(日毎)',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('target_ymd', 'date', [
                'comment' => '対象日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('summary_type', 'string', [
                'comment' => '集計タイプ',
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('groupedby', 'string', [
                'comment' => 'グループ元',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('counter', 'integer', [
                'comment' => 'カウンタ',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('operation_logs_hourly', [
                'comment' => '操作ログの集計(1時間毎)',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('target_time', 'datetime', [
                'comment' => '対象日時',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('summary_type', 'string', [
                'comment' => '集計タイプ',
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('groupedby', 'string', [
                'comment' => 'グループ元',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('counter', 'integer', [
                'comment' => 'カウンタ',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('operation_logs_monthly', [
                'comment' => '操作ログの集計(月毎)',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('target_ym', 'integer', [
                'comment' => '対象年月',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('summary_type', 'string', [
                'comment' => '集計タイプ',
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('groupedby', 'string', [
                'comment' => 'グループ元',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('counter', 'integer', [
                'comment' => 'カウンタ',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('staffs', [
                'comment' => 'スタッフ',
            ])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'comment' => 'ID',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'comment' => 'スタッフ名',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('name_en', 'string', [
                'comment' => 'スタッフ名(英)',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('staff_position', 'char', [
                'comment' => 'スタッフ役職',
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('photo_position', 'char', [
                'comment' => '画像表示位置',
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('photo', 'json', [
                'comment' => 'スタッフ画像',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('description1', 'text', [
                'comment' => 'スタッフ説明1',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('midashi1', 'string', [
                'comment' => '見出し1',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description2', 'text', [
                'comment' => 'スタッフ説明2',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('search_snippet', 'text', [
                'comment' => 'フリーワード検索用のスニペット',
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'comment' => '削除日時',
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {
        $this->table('access_maps')->drop()->save();
        $this->table('admins')->drop()->save();
        $this->table('charge_details')->drop()->save();
        $this->table('charges')->drop()->save();
        $this->table('contacts')->drop()->save();
        $this->table('links')->drop()->save();
        $this->table('operation_logs')->drop()->save();
        $this->table('operation_logs_daily')->drop()->save();
        $this->table('operation_logs_hourly')->drop()->save();
        $this->table('operation_logs_monthly')->drop()->save();
        $this->table('staffs')->drop()->save();
    }
}
