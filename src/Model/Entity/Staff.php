<?php
declare(strict_types=1);

namespace App\Model\Entity;

/**
 * Staff Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $name_en
 * @property string|null $staff_position
 * @property string|null $photo_position
 * @property array|null $photo
 * @property string|null $description1
 * @property string|null $midashi1
 * @property string|null $description2
 * @property string|null $search_snippet
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 */
class Staff extends AppEntity
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
        'name_en' => true,
        'staff_position' => true,
        'photo_position' => true,
        'photo' => true,
        'description1' => true,
        'midashi1' => true,
        'description2' => true,
        'search_snippet' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
    ];
}
