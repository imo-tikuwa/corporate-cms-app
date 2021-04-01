<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * ChargeDetail cell
 */
class ChargeDetailCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->viewBuilder()->setHelpers([
            'Form' => ['templates' => 'form-templates'],
        ]);
    }

    /**
     * Default display method.
     *
     * @param \App\Model\Entity\ChargeDetail $charge_detail entity class object.
     * @param mixed $append_index 関連テーブル内におけるインデックス
     * @return void
     */
    public function display(\App\Model\Entity\ChargeDetail $charge_detail, $append_index)
    {
        $this->set([
            'charge_detail' => $charge_detail,
            'append_index' => (isset($append_index) && is_numeric($append_index)) ? (int)$append_index : 0,
            'id_prefix' => uniqid('i'),
        ]);
    }
}
