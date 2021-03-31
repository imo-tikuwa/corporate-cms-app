<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Charge $charge
 */
$button_name = (!empty($charge) && !$charge->isNew()) ? "更新" : "登録";
$this->assign('title', "基本料金{$button_name}");
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
          <?= $this->Form->button($button_name, ['class' => "btn btn-flat btn-outline-secondary"]) ?>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

