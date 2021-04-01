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
 * ChargeDetails Model
 *
 * @property \App\Model\Table\ChargesTable&\Cake\ORM\Association\BelongsTo $Charges
 *
 * @method \App\Model\Entity\ChargeDetail newEmptyEntity()
 * @method \App\Model\Entity\ChargeDetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChargeDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ChargeDetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ChargeDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeDetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChargeDetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeDetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ChargeDetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeDetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeDetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ChargeDetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChargeDetailsTable extends AppTable
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

        $this->setTable('charge_details');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->belongsTo('Charges', [
            'foreignKey' => 'charge_id',
            'joinType' => 'INNER',
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

        // 料金名
        $validator
            ->requirePresence('name', true, '料金名を入力してください。')
            ->add('name', 'scalar', [
                'rule' => 'isScalar',
                'message' => '料金名を正しく入力してください。',
                'last' => true
            ])
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => '料金名は255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('name', '料金名を入力してください。');

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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['charge_id'], 'Charges'));

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
     * @return \App\Model\Entity\ChargeDetail
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        return parent::patchEntity($entity, $data, $options);
    }
}
