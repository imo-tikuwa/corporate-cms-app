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
 * AccessMaps Model
 *
 * @method \App\Model\Entity\AccessMap newEmptyEntity()
 * @method \App\Model\Entity\AccessMap newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AccessMap[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessMap get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessMap findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AccessMap patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessMap[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessMap|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessMap saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessMap[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccessMap[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccessMap[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AccessMap[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccessMapsTable extends AppTable
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

        $this->setTable('access_maps');
        $this->setDisplayField('id');
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

        // アクセス方法
        $validator
            ->add('description', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'アクセス方法を正しく入力してください。',
                'last' => true
            ])
            ->add('description', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'アクセス方法は255文字以内で入力してください。',
                'last' => true
            ])
            ->allowEmptyString('description');

        // GoogleMap地図座標
        $validator
            ->add('location', 'gmapJsonValid', [
                'rule' => function ($value) {
                    if (!empty(array_diff(['zoom', 'latitude', 'longitude'], array_keys($value)))) {
                        return false;
                    }
                    return true;
                },
                'message' => 'GoogleMap地図座標のデータが正しくありません。',
                'last' => true
            ])
            ->notEmptyString('location', 'GoogleMap地図座標を選択してください。');

        // 地図リンク
        $validator
            ->add('map_link', 'scalar', [
                'rule' => 'isScalar',
                'message' => '地図リンクを正しく入力してください。',
                'last' => true
            ])
            ->allowEmptyString('map_link');

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
        // GoogleMap地図座標
        if (isset($data['location']) && !empty($data['location']) && is_string($data['location'])) {
            $data['location'] = json_decode($data['location'], true);
        }

        return parent::patchEntity($entity, $data, $options);
    }
}
