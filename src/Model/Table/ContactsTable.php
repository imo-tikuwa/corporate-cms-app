<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Contacts Model
 *
 * @method \App\Model\Entity\Contact newEmptyEntity()
 * @method \App\Model\Entity\Contact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Contact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contact get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactsTable extends AppTable
{
    /** 論理削除を行う */
    use SoftDeleteTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contacts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        // ID
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        // お名前
        $validator
            ->add('name', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'お名前を正しく入力してください。',
                'last' => true
            ])
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'お名前は255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('name', 'お名前を入力してください。');

        // メールアドレス
        $validator
            ->add('email', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'メールアドレスを正しく入力してください。',
                'last' => true
            ])
            ->notEmptyString('email', 'メールアドレスを入力してください。');

        // お問い合わせ内容
        $validator
            ->add('type', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'お問い合わせ内容を正しく入力してください。',
                'last' => true
            ])
            ->add('type', 'maxLength', [
                'rule' => ['maxLength', 2],
                'message' => 'お問い合わせ内容は2文字以内で入力してください。',
                'last' => true
            ])
            ->add('type', 'existIn', [
                'rule' => function ($value) {
                    return array_key_exists($value, _code('Codes.Contacts.type'));
                },
                'message' => 'お問い合わせ内容に不正な値が含まれています。',
                'last' => true
            ])
            ->notEmptyString('type', 'お問い合わせ内容を選択してください。');

        // お電話番号
        $validator
            ->add('tel', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'お電話番号を正しく入力してください。',
                'last' => true
            ])
            ->add('tel', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'お電話番号は255文字以内で入力してください。',
                'last' => true
            ])
            ->allowEmptyString('tel');

        // ご希望日時／その他ご要望等
        $validator
            ->add('content', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'ご希望日時／その他ご要望等を正しく入力してください。',
                'last' => true
            ])
            ->notEmptyString('content', 'ご希望日時／その他ご要望等を入力してください。');

        // ホームページURL
        $validator
            ->add('hp_url', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'ホームページURLを正しく入力してください。',
                'last' => true
            ])
            ->add('hp_url', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'ホームページURLは255文字以内で入力してください。',
                'last' => true
            ])
            ->allowEmptyString('hp_url');

        return $validator;
    }

    /**
     * patchEntityのオーバーライド
     * ファイル項目、GoogleMap項目のJSON文字列を配列に変換する
     *
     * @see \Cake\ORM\Table::patchEntity()
     * @param EntityInterface $entity エンティティ
     * @param array $data エンティティに上書きするデータ
     * @param array $options オプション配列
     * @return \Cake\Datasource\EntityInterface
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        $search_snippet[] = $data['name'];
        $search_snippet[] = $data['email'];
        if (isset($data['type']) && $data['type'] != '') {
            $search_snippet[] = _code("Codes.Contacts.type.{$data['type']}");
        }
        $search_snippet[] = $data['tel'];
        $search_snippet[] = strip_tags($data['content']);
        $search_snippet[] = $data['hp_url'];
        $data['search_snippet'] = implode(' ', $search_snippet);

        return parent::patchEntity($entity, $data, $options);
    }

    /**
     * CSVヘッダー情報を取得する
     * @return array
     */
    public function getCsvHeaders()
    {
        return [
            'ID',
            'お名前',
            'メールアドレス',
            'お問い合わせ内容',
            'お電話番号',
            'ご希望日時／その他ご要望等',
            'ホームページURL',
            '作成日時',
            '更新日時',
        ];
    }

    /**
     * CSVカラム情報を取得する
     * @return array
     */
    public function getCsvColumns()
    {
        return [
            'id',
            'name',
            'email',
            'type',
            'tel',
            'content',
            'hp_url',
            'created',
            'modified',
        ];
    }

    /**
     * CSVの入力情報を取得する
     * @param array $csv_row CSVの1行辺りの配列データ
     * @return array データ登録用に変換した配列データ
     */
    public function getCsvData($csv_row)
    {
        $csv_data = array_combine($this->getCsvColumns(), $csv_row);

        // お問い合わせ内容
        $codes = array_flip(_code("Codes.Contacts.type"));
        foreach ($codes as $code_value => $code_key) {
            if ($code_value === $csv_data['type']) {
                $csv_data['type'] = $code_key;
            }
        }
        unset($csv_data['created']);
        unset($csv_data['modified']);

        return $csv_data;
    }
}
