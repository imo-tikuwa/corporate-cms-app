<?php
declare(strict_types=1);

namespace App\Model\Entity;

/**
 * Link Entity
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $title
 * @property string|null $url
 * @property string|null $description
 * @property string|null $search_snippet
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $deleted
 */
class Link extends AppEntity
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
        'category' => true,
        'title' => true,
        'url' => true,
        'description' => true,
        'search_snippet' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
    ];
}
