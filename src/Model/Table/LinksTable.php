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
            ->requirePresence('category', true, 'リンクカテゴリを選択してください。')
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
            ->requirePresence('title', true, 'リンクタイトルを入力してください。')
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
            ->requirePresence('url', true, 'リンクURLを入力してください。')
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
     * CSV import validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationCsv(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);

        return $validator;
    }

    /**
     * Excel import validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationExcel(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);

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
     * @return \App\Model\Entity\Link
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        if (isset($data['category']) && $data['category'] != '') {
            $search_snippet[] = _code("Codes.Links.category.{$data['category']}");
        }
        if (isset($data['title']) && $data['title'] != '') {
            $search_snippet[] = $data['title'];
        }
        if (isset($data['url']) && $data['url'] != '') {
            $search_snippet[] = $data['url'];
        }
        if (isset($data['description']) && $data['description'] != '') {
            $search_snippet[] = strip_tags($data['description']);
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
        // リンクカテゴリ
        if (isset($request['category']) && !is_null($request['category']) && $request['category'] !== '') {
            $query->where([$this->aliasField('category') => $request['category']]);
        }
        // リンクタイトル
        if (isset($request['title']) && !is_null($request['title']) && $request['title'] !== '') {
            $query->where([$this->aliasField('title LIKE') => "%{$request['title']}%"]);
        }
        // リンクURL
        if (isset($request['url']) && !is_null($request['url']) && $request['url'] !== '') {
            $query->where([$this->aliasField('url LIKE') => "%{$request['url']}%"]);
        }
        // リンク説明
        if (isset($request['description']) && !is_null($request['description']) && $request['description'] !== '') {
            $query->where([$this->aliasField('description LIKE') => "%{$request['description']}%"]);
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
     * CSVの入力情報を元にエンティティを作成する
     * @param array $csv_row CSVの1行辺りの配列データ
     * @return \App\Model\Entity\Link エンティティ
     */
    public function createEntityByCsvRow($csv_row)
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

        // Csvの入力情報を元にエンティティを作成
        if (!empty($csv_data['id'])) {
            $link = $this->get($csv_data['id']);
            $this->touch($link);
        } else {
            $link = $this->newEmptyEntity();
        }
        $link = $this->patchEntity($link, $csv_data, ['validate' => 'csv']);

        return $link;
    }

    /**
     * Excelカラム情報を取得する
     * @return array
     */
    public function getExcelColumns()
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
     * Excelの入力情報を元にエンティティを作成する
     * @param array $excel_row Excelの1行辺りの配列データ
     * @return \App\Model\Entity\Link
     */
    public function createEntityByExcelRow($excel_row)
    {
        $excel_data = array_combine($this->getExcelColumns(), $excel_row);

        // リンクカテゴリ
        foreach (_code("Codes.Links.category") as $code_key => $code_value) {
            if ("{$code_key}:{$code_value}" === $excel_data['category']) {
                $excel_data['category'] = $code_key;
            }
        }

        unset($excel_data['created']);
        unset($excel_data['modified']);

        // Excelの入力情報を元にエンティティを作成
        if (!empty($excel_data['id'])) {
            $link = $this->get($excel_data['id']);
            $this->touch($link);
        } else {
            $link = $this->newEmptyEntity();
        }
        $link = $this->patchEntity($link, $excel_data, ['validate' => 'excel']);

        return $link;
    }
}
