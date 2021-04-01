<?php
declare(strict_types=1);

namespace App\Model\Entity;

/**
 * ChargeDetail Entity
 *
 * @property int $id
 * @property int $charge_id
 * @property string|null $name
 * @property int|null $basic_charge
 * @property int|null $campaign_charge
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\Charge $charge
 */
class ChargeDetail extends AppEntity
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
        'charge_id' => true,
        'name' => true,
        'basic_charge' => true,
        'campaign_charge' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'charge' => true,
    ];
}
