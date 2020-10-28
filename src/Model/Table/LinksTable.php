<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Links Model
 *
 * @method \App\Model\Entity\Link newEmptyEntity()
 * @method \App\Model\Entity\Link newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Link[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Link get($primaryKey, $options = [])
 * @method \App\Model\Entity\Link findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Link patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Link[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Link|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Link saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LinksTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('links');
        $this->setDisplayField('title');
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

        // リンクカテゴリ
        $validator
            ->add('category', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'リンクカテゴリを正しく入力してください。',
                'last' => true
            ])
            ->add('category', 'maxLength', [
                'rule' => ['maxLength', 2],
                'message' => 'リンクカテゴリは2文字以内で入力してください。',
                'last' => true
            ])
            ->add('category', 'existIn', [
                'rule' => function ($value) {
                    return array_key_exists($value, _code('Codes.Links.category'));
                },
                'message' => 'リンクカテゴリに不正な値が含まれています。',
                'last' => true
            ])
            ->notEmptyString('category', 'リンクカテゴリを選択してください。');

        // リンクタイトル
        $validator
            ->add('title', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'リンクタイトルを正しく入力してください。',
                'last' => true
            ])
            ->add('title', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'リンクタイトルは255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('title', 'リンクタイトルを入力してください。');

        // リンクURL
        $validator
            ->add('url', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'リンクURLを正しく入力してください。',
                'last' => true
            ])
            ->add('url', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'リンクURLは255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('url', 'リンクURLを入力してください。');

        // リンク説明
        $validator
            ->add('description', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'リンク説明を正しく入力してください。',
                'last' => true
            ])
            ->allowEmptyString('description');

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
        if (isset($data['category']) && $data['category'] != '') {
            $search_snippet[] = _code("Codes.Links.category.{$data['category']}");
        }
        $search_snippet[] = $data['title'];
        $search_snippet[] = $data['url'];
        $search_snippet[] = strip_tags($data['description']);
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
            'リンクカテゴリ',
            'リンクタイトル',
            'リンクURL',
            'リンク説明',
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
            'category',
            'title',
            'url',
            'description',
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

        // リンクカテゴリ
        $codes = array_flip(_code("Codes.Links.category"));
        foreach ($codes as $code_value => $code_key) {
            if ($code_value === $csv_data['category']) {
                $csv_data['category'] = $code_key;
            }
        }
        unset($csv_data['created']);
        unset($csv_data['modified']);

        return $csv_data;
    }
}
