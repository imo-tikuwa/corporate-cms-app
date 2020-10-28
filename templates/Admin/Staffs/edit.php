<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
$button_name = (!empty($staff) && !$staff->isNew()) ? "更新" : "登録";
$this->assign('title', "スタッフ{$button_name}");
if ($staff->hasErrors()) {
  $this->assign('validation_error', $this->makeValidationErrorHtml($staff->getErrorMessages()));
}
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($staff) ?>
      <div class="row">
        <div class="col-lg-2 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'name', 'label' => 'スタッフ名', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('name', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '50']); ?>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'name_en', 'label' => 'スタッフ名(英)', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('name_en', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '50']); ?>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'staff_position', 'label' => 'スタッフ役職', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('staff_position', ['id' => 'staff_position', 'type' => 'select', 'options' => _code('Codes.Staffs.staff_position'), 'class' => 'form-control ', 'label' => false, 'required' => false, 'error' => false, 'default' => '01', 'empty' => '　']); ?>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'photo_position', 'label' => '画像表示位置', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('photo_position', ['id' => 'photo_position', 'type' => 'select', 'options' => _code('Codes.Staffs.photo_position'), 'class' => 'form-control ', 'label' => false, 'required' => false, 'error' => false, 'default' => '01', 'empty' => '　']); ?>
          </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'photo', 'label' => 'スタッフ画像', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('photo_file', ['type' => 'file', 'id' => 'photo-file-input', 'label' => false]); ?>
            <?php
            $photo_initial_preview = [];
            $photo_initial_preview_config = [];
            if (!empty($staff['photo'])) foreach ($staff['photo'] as $each_data) {
                $photo_initial_preview[] = "/" . UPLOAD_FILE_BASE_DIR_NAME . "/staffs/{$each_data['cur_name']}";
                $photo_initial_preview_config[] = [
                    "caption" => $each_data['org_name'],
                    "size" => $each_data['size'],
                    "url" =>  $each_data['delete_url'],
                    "key" => $each_data['key'],
                    "downloadUrl" => "/" . UPLOAD_FILE_BASE_DIR_NAME . "/staffs/{$each_data['key']}",
                ];
            }
            ?>
            <?= $this->Form->hidden('photo', ['id' => 'photo-file-hidden', 'required' => false, 'error' => false, 'value' => !empty($staff['photo']) ? json_encode($staff['photo']) : '',
                'data-initial-preview' => json_encode($photo_initial_preview),
                'data-initial-preview-config' => json_encode($photo_initial_preview_config)
            ]); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'description1', 'label' => 'スタッフ説明1', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('description1', ['type' => 'textarea', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'rows' => '5', 'maxlength' => '1000']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'midashi1', 'label' => '見出し1', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('midashi1', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '80']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'description2', 'label' => 'スタッフ説明2', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('description2', ['type' => 'textarea', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'rows' => '5', 'maxlength' => '1000']); ?>
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

<?= $this->Html->script('admin/staffs_edit', ['block' => true, 'charset' => 'UTF-8']) ?>
