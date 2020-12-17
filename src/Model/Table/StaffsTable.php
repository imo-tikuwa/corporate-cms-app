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
 * Staffs Model
 *
 * @method \App\Model\Entity\Staff newEmptyEntity()
 * @method \App\Model\Entity\Staff newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Staff[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Staff get($primaryKey, $options = [])
 * @method \App\Model\Entity\Staff findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Staff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Staff[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Staff|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Staff saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StaffsTable extends AppTable
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

        $this->setTable('staffs');
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

        // スタッフ名
        $validator
            ->requirePresence('name', true, 'スタッフ名を入力してください。')
            ->add('name', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'スタッフ名を正しく入力してください。',
                'last' => true
            ])
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'スタッフ名は255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('name', 'スタッフ名を入力してください。');

        // スタッフ名(英)
        $validator
            ->requirePresence('name_en', true, 'スタッフ名(英)を入力してください。')
            ->add('name_en', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'スタッフ名(英)を正しく入力してください。',
                'last' => true
            ])
            ->add('name_en', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => 'スタッフ名(英)は255文字以内で入力してください。',
                'last' => true
            ])
            ->notEmptyString('name_en', 'スタッフ名(英)を入力してください。');

        // スタッフ役職
        $validator
            ->requirePresence('staff_position', true, 'スタッフ役職を選択してください。')
            ->add('staff_position', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'スタッフ役職を正しく入力してください。',
                'last' => true
            ])
            ->add('staff_position', 'maxLength', [
                'rule' => ['maxLength', 2],
                'message' => 'スタッフ役職は2文字以内で入力してください。',
                'last' => true
            ])
            ->add('staff_position', 'existIn', [
                'rule' => function ($value) {
                    return array_key_exists($value, _code('Codes.Staffs.staff_position'));
                },
                'message' => 'スタッフ役職に不正な値が含まれています。',
                'last' => true
            ])
            ->notEmptyString('staff_position', 'スタッフ役職を選択してください。');

        // 画像表示位置
        $validator
            ->requirePresence('photo_position', true, '画像表示位置を選択してください。')
            ->add('photo_position', 'scalar', [
                'rule' => 'isScalar',
                'message' => '画像表示位置を正しく入力してください。',
                'last' => true
            ])
            ->add('photo_position', 'maxLength', [
                'rule' => ['maxLength', 2],
                'message' => '画像表示位置は2文字以内で入力してください。',
                'last' => true
            ])
            ->add('photo_position', 'existIn', [
                'rule' => function ($value) {
                    return array_key_exists($value, _code('Codes.Staffs.photo_position'));
                },
                'message' => '画像表示位置に不正な値が含まれています。',
                'last' => true
            ])
            ->notEmptyString('photo_position', '画像表示位置を選択してください。');

        // スタッフ画像
        $validator
            ->requirePresence('photo', true, 'スタッフ画像は必須です')
            ->add('photo', 'fileJsonValid', [
                'rule' => function ($values) {
                    foreach ($values as $value) {
                        if (!empty(array_diff(['key', 'size', 'cur_name', 'org_name', 'delete_url'], array_keys($value)))) {
                            return false;
                        }
                    }
                    return true;
                },
                'message' => 'スタッフ画像のデータが正しくありません。',
                'last' => true
            ])
            ->notEmptyArray('photo', 'スタッフ画像は必須です');

        // スタッフ説明1
        $validator
            ->add('description1', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'スタッフ説明1を正しく入力してください。',
                'last' => true
            ])
            ->allowEmptyString('description1');

        // 見出し1
        $validator
            ->add('midashi1', 'scalar', [
                'rule' => 'isScalar',
                'message' => '見出し1を正しく入力してください。',
                'last' => true
            ])
            ->add('midashi1', 'maxLength', [
                'rule' => ['maxLength', 255],
                'message' => '見出し1は255文字以内で入力してください。',
                'last' => true
            ])
            ->allowEmptyString('midashi1');

        // スタッフ説明2
        $validator
            ->add('description2', 'scalar', [
                'rule' => 'isScalar',
                'message' => 'スタッフ説明2を正しく入力してください。',
                'last' => true
            ])
            ->allowEmptyString('description2');

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
     * @return \App\Model\Entity\Staff
     */
    public function patchEntity(EntityInterface $entity, array $data, array $options = []): EntityInterface
    {
        // スタッフ画像
        if (isset($data['photo']) && !empty($data['photo']) && is_string($data['photo'])) {
            $data['photo'] = json_decode($data['photo'], true);
        }

        // フリーワード検索のスニペット更新
        $search_snippet = [];
        if (isset($data['name']) && $data['name'] != '') {
            $search_snippet[] = $data['name'];
        }
        if (isset($data['name_en']) && $data['name_en'] != '') {
            $search_snippet[] = $data['name_en'];
        }
        if (isset($data['staff_position']) && $data['staff_position'] != '') {
            $search_snippet[] = _code("Codes.Staffs.staff_position.{$data['staff_position']}");
        }
        if (isset($data['photo_position']) && $data['photo_position'] != '') {
            $search_snippet[] = _code("Codes.Staffs.photo_position.{$data['photo_position']}");
        }
        if (isset($data['description1']) && $data['description1'] != '') {
            $search_snippet[] = strip_tags($data['description1']);
        }
        if (isset($data['midashi1']) && $data['midashi1'] != '') {
            $search_snippet[] = $data['midashi1'];
        }
        if (isset($data['description2']) && $data['description2'] != '') {
            $search_snippet[] = strip_tags($data['description2']);
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
            'スタッフ名',
            'スタッフ名(英)',
            'スタッフ役職',
            '画像表示位置',
            'スタッフ説明1',
            '見出し1',
            'スタッフ説明2',
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
            'name_en',
            'staff_position',
            'photo_position',
            'description1',
            'midashi1',
            'description2',
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
            'name_en',
            'staff_position',
            'photo_position',
            'description1',
            'midashi1',
            'description2',
            'created',
            'modified',
        ];
    }
}
