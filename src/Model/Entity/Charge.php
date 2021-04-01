<?php
declare(strict_types=1);

namespace App\Model\Entity;

/**
 * Charge Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $annotation
 * @property string|null $search_snippet
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\ChargeDetail[] $charge_details
 */
class Charge extends AppEntity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'annotation' => true,
        'search_snippet' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'charge_details' => true,
    ];

    /**
     * 関連エンティティのプロパティ名 => 論理名のデータ配列を返す
     *
     * @return array
     */
    protected function _getRelatedEntityNames()
    {
        return [
            'charge_details' => '料金詳細',
        ];
    }
}
