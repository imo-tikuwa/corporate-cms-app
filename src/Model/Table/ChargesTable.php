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
 * Charges Model
 *
 * @property \App\Model\Table\ChargeRelationsTable&\Cake\ORM\Association\HasMany $ChargeRelations
 *
 * @method \App\Model\Entity\Charge newEmptyEntity()
 * @method \App\Model\Entity\Charge newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Charge[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Charge get($primaryKey, $options = [])
 * @method \App\Model\Entity\Charge findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Charge patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Charge[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Charge|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Charge saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Charge[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Charge[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Charge[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Charge[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ChargesTable extends AppTable
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

        $this->setTable('charges');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->hasMany('ChargeRelations', [
            'foreignKey' => 'charge_id',
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

        // プラン名
        $validator
            ->requirePresence('name', true, 'プラン名を入力してください。')
            ->add('name', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'プラン名を正しく入力してください。',
                'last' => true
            ])
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'プラン名は255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('name', 'プラン名を入力してください。');

        // プラン名下注釈
        $validator
            ->add('annotation', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'プラン名下注釈を正しく入力してください。',
                'last' => true
            ])
            ->add('annotation', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'プラン名下注釈は255文字以内で入力してください。',
                'last' => true
            ])
            ->allowEmptyString('annotation');

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
     * @return \App\Model\Entity\Charge
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        if (isset($data['name']) && $data['name'] != '') {
            $search_snippet[] = $data['name'];
        }
        if (isset($data['annotation']) && $data['annotation'] != '') {
            $search_snippet[] = $data['annotation'];
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
            'プラン名',
            'プラン名下注釈',
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
            'annotation',
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
            'annotation',
            'created',
            'modified',
        ];
    }
}
