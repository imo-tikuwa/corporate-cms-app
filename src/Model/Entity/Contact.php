<?php
declare(strict_types=1);

namespace App\Model\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $type
 * @property string|null $tel
 * @property string|null $content
 * @property string|null $hp_url
 * @property string|null $search_snippet
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 */
class Contact extends AppEntity
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
        'email' => true,
        'type' => true,
        'tel' => true,
        'content' => true,
        'hp_url' => true,
        'search_snippet' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
    ];
}
