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
 * ChargeMasters Model
 *
 * @property \App\Model\Table\ChargeRelationsTable&\Cake\ORM\Association\HasMany $ChargeRelations
 *
 * @method \App\Model\Entity\ChargeMaster newEmptyEntity()
 * @method \App\Model\Entity\ChargeMaster newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChargeMaster findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChargeMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeMaster|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeMaster[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChargeMastersTable extends AppTable
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

        $this->setTable('charge_masters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->hasMany('ChargeRelations', [
            'foreignKey' => 'charge_master_id',
        ]);
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

        // マスタ名
        $validator
            ->requirePresence('name', true, 'マスタ名を入力してください。')
            ->add('name', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'マスタ名を正しく入力してください。',
                'last' => true
            ])
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'マスタ名は255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('name', 'マスタ名を入力してください。');

        // 基本料金
        $validator
            ->requirePresence('basic_charge', true, '基本料金を入力してください。')
            ->add('basic_charge', 'integer', [
                'rule' => 'isInteger',
                'message' => '基本料金を正しく入力してください。',
                'last' => true
            ])
            ->add('basic_charge', 'greaterThanOrEqual', [
                'rule' => ['comparison', '>=', 0],
                'message' => '基本料金は0以上の値で入力してください。',
                'last' => true
            ])
            ->add('basic_charge', 'lessThanOrEqual', [
                'rule' => ['comparison', '<=', 99900],
                'message' => '基本料金は99900以下の値で入力してください。',
                'last' => true
            ])
            ->notEmptyString('basic_charge', '基本料金を入力してください。');

        // キャンペーン料金
        $validator
            ->requirePresence('campaign_charge', true, 'キャンペーン料金を入力してください。')
            ->add('campaign_charge', 'integer', [
                'rule' => 'isInteger',
                'message' => 'キャンペーン料金を正しく入力してください。',
                'last' => true
            ])
            ->add('campaign_charge', 'greaterThanOrEqual', [
                'rule' => ['comparison', '>=', 0],
                'message' => 'キャンペーン料金は0以上の値で入力してください。',
                'last' => true
            ])
            ->add('campaign_charge', 'lessThanOrEqual', [
                'rule' => ['comparison', '<=', 99900],
                'message' => 'キャンペーン料金は99900以下の値で入力してください。',
                'last' => true
            ])
            ->notEmptyString('campaign_charge', 'キャンペーン料金を入力してください。');

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
     * @return \App\Model\Entity\ChargeMaster
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        if (isset($data['name']) && $data['name'] != '') {
            $search_snippet[] = $data['name'];
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
        // マスタ名
        if (isset($request['name']) && !is_null($request['name']) && $request['name'] !== '') {
            $query->where([$this->aliasField('name LIKE') => "%{$request['name']}%"]);
        }
        // 基本料金
        if (isset($request['basic_charge']) && !is_null($request['basic_charge']) && $request['basic_charge'] !== '') {
            $query->where([$this->aliasField('basic_charge <=') => $request['basic_charge']]);
        }
        // キャンペーン料金
        if (isset($request['campaign_charge']) && !is_null($request['campaign_charge']) && $request['campaign_charge'] !== '') {
            $query->where([$this->aliasField('campaign_charge <=') => $request['campaign_charge']]);
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
            'マスタ名',
            '基本料金',
            'キャンペーン料金',
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
            'basic_charge',
            'campaign_charge',
            'created',
            'modified',
        ];
    }
}
