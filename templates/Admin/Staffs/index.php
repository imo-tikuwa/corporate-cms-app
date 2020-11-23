<?php
use App\Utils\AuthUtils;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
$this->assign('title', "スタッフ");
?>
<div class="col-md-12 mb-12">
  <div class="card rounded-0">
    <div class="card-header">
      <div class="form-inline">
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_ADD])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_ADD]) ?>'">新規登録</button>
        <?php } ?>
        <button type="button" class="btn btn-flat btn-outline-secondary mr-2" data-toggle="modal" data-target="#staffs-search-form-modal">検索</button>
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_CSV_EXPORT])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_CSV_EXPORT, '?' => $this->getRequest()->getQueryParams()]) ?>'">CSVエクスポート</button>
        <?php } ?>
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_EXCEL_EXPORT])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_EXCEL_EXPORT, '?' => $this->getRequest()->getQueryParams()]) ?>'">Excelエクスポート</button>
        <?php } ?>
        <div class="freeword-search input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <?= $this->Form->control('search_snippet_format', ['type' => 'radio', 'options' => _code('Others.search_snippet_format'), 'class' => 'form-check-label col-form-label col-form-label-sm staffs-freeword-search-snippet-format', 'default' => 'AND', 'value' => @$params['search_snippet_format'], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}{{input}}<small><label {{attrs}}>{{text}}</label></small>', 'radioWrapper' => '{{label}}', 'inputContainer' => '{{content}}']]) ?>
            </div>
          </div>
          <?= $this->Form->text('search_snippet', ['id' => 'staffs-freeword-search-snippet', 'class' => 'form-control rounded-0', 'value' => @$params['search_snippet'], 'style' => 'width: 200px;', 'placeholder' => 'フリーワード']) ?>
          <div class="input-group-append">
            <button type="button" id="staffs-freeword-search-btn" class="btn btn-flat btn-outline-secondary"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'staffs-freeword-search-form', 'class' => 'd-none']) ?>
          <?= $this->Form->hidden('search_snippet', ['id' => 'staffs-freeword-hidden-search-snippet', 'value' => @$params['search_snippet']]) ?>
          <?= $this->Form->hidden('search_snippet_format', ['id' => 'staffs-freeword-hidden-search-snippet-format', 'value' => @$params['search_snippet_format']]) ?>
          <?= $this->Form->hidden('sort', ['value' => @$params['sort']]) ?>
          <?= $this->Form->hidden('direction', ['value' => @$params['direction']]) ?>
        <?= $this->Form->end(); ?>
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name', 'スタッフ名') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name_en', 'スタッフ名(英)') ?></th>
            <th scope="col"><?= $this->Paginator->sort('staff_position', 'スタッフ役職') ?></th>
            <th scope="col"><?= $this->Paginator->sort('photo_position', '画像表示位置') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified', '更新日時') ?></th>
            <th scope="col" class="actions">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($staffs as $staff) { ?>
            <tr>
              <td><?= $this->Html->link($staff->id, ['action' => ACTION_VIEW, $staff->id]) ?></td>
              <td><?= h($staff->name) ?></td>
              <td><?= h($staff->name_en) ?></td>
              <td><?= @h(_code("Codes.Staffs.staff_position.{$staff->staff_position}")) ?></td>
              <td><?= @h(_code("Codes.Staffs.photo_position.{$staff->photo_position}")) ?></td>
              <td>
                <?php if (!is_null($staff->modified)) { ?>
                  <?= h($staff->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
                <?php } ?>
              </td>
              <td class="actions">
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop<?= $staff->id ?>" type="button" class="btn btn-sm btn-flat btn-outline-secondary dropdown-toggle index-dropdown-toggle" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"></button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop<?= $staff->id ?>">
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_VIEW])) { ?>
                      <?= $this->Html->link('詳細', ['action' => ACTION_VIEW, $staff->id], ['class' => 'dropdown-item']) ?>
                    <?php } ?>
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_EDIT])) { ?>
                      <?= $this->Html->link('編集', ['action' => ACTION_EDIT, $staff->id], ['class' => 'dropdown-item']) ?>
                    <?php } ?>
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_DELETE])) { ?>
                      <?= $this->Form->postLink('削除', ['action' => ACTION_DELETE, $staff->id], ['class' => 'dropdown-item', 'confirm' => __('ID {0} を削除します。よろしいですか？', $staff->id)]) ?>
                    <?php } ?>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?= $this->element('pager') ?>
</div>

<div class="modal search-form fade" id="staffs-search-form-modal" tabindex="-1" role="dialog" aria-labelledby="staffs-search-form-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">スタッフ検索</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'staffs-search-form']) ?>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('id', ['class' => 'form-control rounded-0', 'label' => 'ID', 'value' => @$params['id']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('name', ['class' => 'form-control rounded-0', 'label' => 'スタッフ名', 'value' => @$params['name']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('name_en', ['class' => 'form-control rounded-0', 'label' => 'スタッフ名(英)', 'value' => @$params['name_en']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('staff_position', ['id' => 'staff_position', 'type' => 'select', 'options' => _code('Codes.Staffs.staff_position'), 'class' => 'form-control', 'label' => 'スタッフ役職', 'empty' => '　', 'value' => @$params['staff_position']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('photo_position', ['id' => 'photo_position', 'type' => 'select', 'options' => _code('Codes.Staffs.photo_position'), 'class' => 'form-control', 'label' => '画像表示位置', 'empty' => '　', 'value' => @$params['photo_position']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('description1', ['class' => 'form-control rounded-0', 'label' => 'スタッフ説明1', 'value' => @$params['description1']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('midashi1', ['class' => 'form-control rounded-0', 'label' => '見出し1', 'value' => @$params['midashi1']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('description2', ['class' => 'form-control rounded-0', 'label' => 'スタッフ説明2', 'value' => @$params['description2']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label for="search_snippet" class="col-form-label">フリーワード</label>
                <div class="freeword-search form-inline input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <?= $this->Form->control('search_snippet_format', ['type' => 'radio', 'id' => 'modal-search_snippet-format', 'options' => _code('Others.search_snippet_format'), 'class' => 'form-check-label col-form-label col-form-label-sm', 'default' => 'AND', 'value' => @$params['search_snippet_format'], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}{{input}}<small><label {{attrs}}>{{text}}</label></small>', 'radioWrapper' => '{{label}}', 'inputContainer' => '{{content}}']]) ?>
                    </div>
                  </div>
                  <?= $this->Form->text('search_snippet', ['class' => 'form-control rounded-0', 'value' => @$params['search_snippet']]) ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <?= $this->Form->button('検索', ['class' => "btn btn-flat btn-outline-secondary btn-block"]) ?>
              </div>
            </div>
          </div>
          <?= $this->Form->hidden('sort', ['value' => @$params['sort']]) ?>
          <?= $this->Form->hidden('direction', ['value' => @$params['direction']]) ?>
        <?= $this->Form->end() ?>
      </div>
      <div class="modal-footer">　</div>
    </div>
  </div>
</div>

<?= $this->Html->script('admin/staffs_index', ['block' => true, 'charset' => 'UTF-8']) ?>
