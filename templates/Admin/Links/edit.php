<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
$button_name = (!empty($link) && !$link->isNew()) ? "更新" : "登録";
$this->assign('title', "リンク集{$button_name}");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($link) ?>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'category', 'label' => 'リンクカテゴリ', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('category', [
              'id' => 'category',
              'type' => 'select',
              'options' => _code('Codes.Links.category'),
              'class' => 'form-control ',
              'label' => false,
              'required' => false,
              'error' => false,
              'default' => '01',
              'empty' => '　'
            ]); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'title', 'label' => 'リンクタイトル', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('title', [
              'type' => 'text',
              'class' => 'form-control rounded-0 ',
              'label' => false,
              'required' => false,
              'maxlength' => '50',
              'error' => false
            ]); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'url', 'label' => 'リンクURL', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('url', [
              'type' => 'text',
              'class' => 'form-control rounded-0 ',
              'label' => false,
              'required' => false,
              'error' => false
            ]); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'description', 'label' => 'リンク説明', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('description', [
              'type' => 'textarea',
              'class' => 'form-control rounded-0 ',
              'label' => false,
              'required' => false,
              'rows' => '3',
              'maxlength' => '500',
              'error' => false
            ]); ?>
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

<?= $this->Html->script('admin/links_edit', ['block' => true, 'charset' => 'UTF-8']) ?>
