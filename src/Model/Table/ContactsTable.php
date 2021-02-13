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
            ->requirePresence('name', true, 'お名前を入力してください。')
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
            ->requirePresence('email', true, 'メールアドレスを入力してください。')
            ->add('email', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'メールアドレスを正しく入力してください。',
                'last' => true
            ])
            ->notEmptyString('email', 'メールアドレスを入力してください。');

        // お問い合わせ内容
        $validator
            ->requirePresence('type', true, 'お問い合わせ内容を選択してください。')
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
            ->requirePresence('content', true, 'ご希望日時／その他ご要望等を入力してください。')
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
     * @return \App\Model\Entity\Contact
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        if (isset($data['name']) && $data['name'] != '') {
            $search_snippet[] = $data['name'];
        }
        if (isset($data['email']) && $data['email'] != '') {
            $search_snippet[] = $data['email'];
        }
        if (isset($data['type']) && $data['type'] != '') {
            $search_snippet[] = _code("Codes.Contacts.type.{$data['type']}");
        }
        if (isset($data['tel']) && $data['tel'] != '') {
            $search_snippet[] = $data['tel'];
        }
        if (isset($data['content']) && $data['content'] != '') {
            $search_snippet[] = strip_tags($data['content']);
        }
        if (isset($data['hp_url']) && $data['hp_url'] != '') {
            $search_snippet[] = $data['hp_url'];
        }
        $data['search_snippet'] = implode(' ', $search_snippet);

        return parent::patchEntity($entity, $data, $options);
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    public function getSearchQuery($request)
    {
        $query = $this->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->aliasField('id') => $request['id']]);
        }
        // お名前
        if (isset($request['name']) && !is_null($request['name']) && $request['name'] !== '') {
            $query->where([$this->aliasField('name LIKE') => "%{$request['name']}%"]);
        }
        // メールアドレス
        if (isset($request['email']) && !is_null($request['email']) && $request['email'] !== '') {
            $query->where([$this->aliasField('email LIKE') => "%{$request['email']}%"]);
        }
        // お問い合わせ内容
        if (isset($request['type']) && !is_null($request['type']) && $request['type'] !== '') {
            $query->where([$this->aliasField('type') => $request['type']]);
        }
        // お電話番号
        if (isset($request['tel']) && !is_null($request['tel']) && $request['tel'] !== '') {
            $query->where([$this->aliasField('tel LIKE') => "%{$request['tel']}%"]);
        }
        // ご希望日時／その他ご要望等
        if (isset($request['content']) && !is_null($request['content']) && $request['content'] !== '') {
            $query->where([$this->aliasField('content LIKE') => "%{$request['content']}%"]);
        }
        // ホームページURL
        if (isset($request['hp_url']) && !is_null($request['hp_url']) && $request['hp_url'] !== '') {
            $query->where([$this->aliasField('hp_url LIKE') => "%{$request['hp_url']}%"]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
            }
            if (isset($request['search_snippet_format']) && $request['search_snippet_format'] == 'AND') {
                $query->where($search_snippet_conditions);
            } else {
                $query->where(function ($exp) use ($search_snippet_conditions) {
                    return $exp->or($search_snippet_conditions);
                });
            }
        }

        return $query;
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
     * Excelカラム情報を取得する
     * @return array
     */
    public function getExcelColumns()
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
}
