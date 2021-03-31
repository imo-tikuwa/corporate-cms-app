<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeRelation $charge_relation
 */
$button_name = (!empty($charge_relation) && !$charge_relation->isNew()) ? "更新" : "登録";
$this->assign('title', "料金マッピング{$button_name}");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($charge_relation) ?>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'charge_id', 'label' => '基本料金ID', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('charge_id', ['id' => 'charge_id', 'type' => 'select', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'empty' => '　']); ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'charge_master_id', 'label' => '料金マスタID', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('charge_master_id', ['id' => 'charge_master_id', 'type' => 'select', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'empty' => '　']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <?= $this->Form->button($button_name, ['class' => "btn btn-flat btn-outline-secondary"]) ?>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<?= $this->Html->script('admin/charge_relations_edit', ['block' => true, 'charset' => 'UTF-8']) ?>
