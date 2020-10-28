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
     * @return \Cake\Datasource\EntityInterface
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // フリーワード検索のスニペット更新
        $search_snippet = [];
        $search_snippet[] = $data['name'];
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

    /**
     * CSVの入力情報を取得する
     * @param array $csv_row CSVの1行辺りの配列データ
     * @return array データ登録用に変換した配列データ
     */
    public function getCsvData($csv_row)
    {
        $csv_data = array_combine($this->getCsvColumns(), $csv_row);

        // 基本料金
        $csv_data['basic_charge'] = preg_replace('/[^0-9]/', '', $csv_data['basic_charge']);
        // キャンペーン料金
        $csv_data['campaign_charge'] = preg_replace('/[^0-9]/', '', $csv_data['campaign_charge']);
        unset($csv_data['created']);
        unset($csv_data['modified']);

        return $csv_data;
    }
}
