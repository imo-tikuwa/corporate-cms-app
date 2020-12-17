<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
$button_name = (!empty($contact) && !$contact->isNew()) ? "更新" : "登録";
$this->assign('title', "お問い合わせ情報{$button_name}");
$this->Form->setTemplates([
  'nestingLabel' => '{{hidden}}{{input}}<label class="form-check-label col-form-label" {{attrs}}>{{text}}</label>'
]);
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($contact) ?>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'name', 'label' => 'お名前', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('name', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '30']); ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'email', 'label' => 'メールアドレス', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('email', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '250']); ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'type', 'label' => 'お問い合わせ内容', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('type', ['type' => 'radio', 'options' => _code('Codes.Contacts.type'), 'label' => false, 'required' => false, 'error' => false, "hiddenField" => false]); ?>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'tel', 'label' => 'お電話番号', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('tel', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '15']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'content', 'label' => 'ご希望日時／その他ご要望等', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('content', ['type' => 'textarea', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'rows' => '5', 'maxlength' => '1000']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'hp_url', 'label' => 'ホームページURL', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('hp_url', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '250']); ?>
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

