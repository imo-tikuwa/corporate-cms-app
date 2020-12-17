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
 * ChargeRelations Model
 *
 * @property \App\Model\Table\ChargesTable&\Cake\ORM\Association\BelongsTo $Charges
 * @property \App\Model\Table\ChargeMastersTable&\Cake\ORM\Association\BelongsTo $ChargeMasters
 *
 * @method \App\Model\Entity\ChargeRelation newEmptyEntity()
 * @method \App\Model\Entity\ChargeRelation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeRelation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeRelation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChargeRelation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChargeRelation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeRelation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeRelation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeRelation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeRelation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeRelation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeRelation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeRelation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChargeRelationsTable extends AppTable
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

        $this->setTable('charge_relations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Charges', [
            'foreignKey' => 'charge_id',
        ]);
        $this->belongsTo('ChargeMasters', [
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

        // 基本料金ID
        $validator
            ->requirePresence('charge_id', true, '基本料金IDを選択してください。')
            ->add('charge_id', 'integer', [
                'rule' => 'isInteger',
                'message' => '基本料金IDを正しく入力してください。',
                'last' => true
            ])
            ->add('charge_id', 'existForeignEntity', [
                'rule' => function ($charge_id) {
                    $table = TableRegistry::getTableLocator()->get('Charges');
                    $entity = $table->find()->select(['id'])->where(['id' => $charge_id])->first();
                    return !empty($entity);
                },
                'message' => '基本料金IDに不正な値が入力されています。',
                'last' => true
            ])
            ->notEmptyString('charge_id', '基本料金IDを選択してください。');

        // 料金マスタID
        $validator
            ->requirePresence('charge_master_id', true, '料金マスタIDを選択してください。')
            ->add('charge_master_id', 'integer', [
                'rule' => 'isInteger',
                'message' => '料金マスタIDを正しく入力してください。',
                'last' => true
            ])
            ->add('charge_master_id', 'existForeignEntity', [
                'rule' => function ($charge_master_id) {
                    $table = TableRegistry::getTableLocator()->get('ChargeMasters');
                    $entity = $table->find()->select(['id'])->where(['id' => $charge_master_id])->first();
                    return !empty($entity);
                },
                'message' => '料金マスタIDに不正な値が入力されています。',
                'last' => true
            ])
            ->notEmptyString('charge_master_id', '料金マスタIDを選択してください。');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['charge_id'], 'Charges'));
        $rules->add($rules->existsIn(['charge_master_id'], 'ChargeMasters'));

        return $rules;
    }

    /**
     * patchEntityのオーバーライド
     * ファイル項目、GoogleMap項目のJSON文字列を配列に変換する
     *
     * @see \Cake\ORM\Table::patchEntity()
     * @param EntityInterface $entity エンティティ
     * @param array $data エンティティに上書きするデータ
     * @param array $options オプション配列
     * @return \App\Model\Entity\ChargeRelation
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        if (isset($data['charge_id'])) {
            $charge = TableRegistry::getTableLocator()->get('Charges')->find()->select(['name'])->where(['id' => $data['charge_id']])->first();
            if (!empty($charge)) {
                $search_snippet[] = $charge->name;
            }
        }
        if (isset($data['charge_master_id'])) {
            $charge_master = TableRegistry::getTableLocator()->get('ChargeMasters')->find()->select(['name'])->where(['id' => $data['charge_master_id']])->first();
            if (!empty($charge_master)) {
                $search_snippet[] = $charge_master->name;
            }
        }
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
            '基本料金ID',
            '料金マスタID',
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
            'charge_id',
            'charge_master_id',
            'created',
            'modified',
        ];
    }
}
