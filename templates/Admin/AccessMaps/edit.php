<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccessMap $access_map
 */
$button_name = (!empty($access_map) && !$access_map->isNew()) ? "更新" : "登録";
$this->assign('title', "アクセスマップ{$button_name}");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <?= $this->Form->create($access_map) ?>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'description', 'label' => 'アクセス方法', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('description', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '100']); ?>
          </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'location-googlemap-container', 'label' => 'GoogleMap地図座標', 'require' => true, 'class' => 'item-label col-form-label']); ?>
            <div id="location-googlemap-container" style="height:350px;"></div>
            <?= $this->Form->hidden('location', ['id' => 'location-latlon-hidden', 'required' => false, 'error' => false, 'value' => !empty($access_map['location']) ? json_encode($access_map['location']) : '']); ?>
          </div>
        </div>
        <?= $this->Html->script('//maps.google.com/maps/api/js?v=3&key=' . env('GOOGLEMAP_API_KEY'), ['block' => true, 'charset' => 'UTF-8']) ?>
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="form-group">
            <?= $this->element('Parts/label', ['field' => 'map_link', 'label' => '地図リンク', 'require' => false, 'class' => 'item-label col-form-label']); ?>
            <?= $this->Form->control('map_link', ['type' => 'text', 'class' => 'form-control rounded-0 ', 'label' => false, 'required' => false, 'error' => false, 'maxlength' => '512']); ?>
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

<?= $this->Html->script('admin/access_maps_edit', ['block' => true, 'charset' => 'UTF-8']) ?>
