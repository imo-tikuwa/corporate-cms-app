<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeMaster $charge_master
 */
$button_name = (!empty($charge_master) && !$charge_master->isNew()) ? "更新" : "登録";
$this->assign('title', "料金マスタ{$button_name}");
if ($charge_master->hasErrors()) {
  $this->assign('validation_error', $this->makeValidationErrorHtml($charge_master->getErrorMessages()));
}
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($charge_master) ?>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'name', 'label' => 'マスタ名', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('name', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '20']); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'basic_charge', 'label' => '基本料金', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <div class="input number">
              <div class="input-group">
                <?= $this->Form->text('basic_charge', ['type' => 'number', 'id' => 'basic_charge', 'class' => 'form-control rounded-0', 'label' => false, 'min' => '0', 'max' => '99900', 'step' => '50', 'required' => false, 'error' => false]); ?>
                <div class="input-group-append"><span class="input-group-text rounded-0">円</span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'campaign_charge', 'label' => 'キャンペーン料金', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <div class="input number">
              <div class="input-group">
                <?= $this->Form->text('campaign_charge', ['type' => 'number', 'id' => 'campaign_charge', 'class' => 'form-control rounded-0', 'label' => false, 'min' => '0', 'max' => '99900', 'step' => '50', 'required' => false, 'error' => false]); ?>
                <div class="input-group-append"><span class="input-group-text rounded-0">円</span></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <?= $this->Form->button($button_name, ['class' => "btn btn-flat btn-outline-secondary"]) ?>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

