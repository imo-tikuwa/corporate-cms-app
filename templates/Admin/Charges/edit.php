<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Charge $charge
 */
$button_name = (!empty($charge) && !$charge->isNew()) ? "更新" : "登録";
$this->assign('title', "料金{$button_name}");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($charge) ?>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'name', 'label' => 'プラン名', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('name', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '20']); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'annotation', 'label' => 'プラン名下注釈', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('annotation', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '20']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="row charge-detail-nav">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <label>料金詳細</label>
              <div class="btn-group">
                <?= $this->Form->button('＋', ['type' => 'button', 'class' => "btn btn-flat btn-outline-secondary append-charge-detail-row"]) ?>
                <?= $this->Form->button('－', ['type' => 'button', 'class' => "btn btn-flat btn-outline-secondary delete-charge-detail-row"]) ?>
              </div>
            </div>
          </div>
          <?php foreach ($charge->charge_details as $charge_detail_index => $charge_detail) { ?>
            <?= $this->cell('ChargeDetail', ['charge_detail' => $charge_detail, 'append_index' => $charge_detail_index])->render(); ?>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <?= $this->Form->button($button_name, ['class' => "btn btn-flat btn-outline-secondary"]) ?>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<?= $this->Html->script('admin/charges_edit', ['block' => true, 'charset' => 'UTF-8']) ?>
