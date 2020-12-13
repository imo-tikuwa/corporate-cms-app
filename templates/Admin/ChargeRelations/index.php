<?php
use App\Utils\AuthUtils;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeRelation[] $charge_relations
 */
$this->assign('title', "料金マッピング");
?>
<div class="col-md-12 mb-12">
  <div class="card rounded-0">
    <div class="card-header">
      <div class="form-inline">
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_ADD])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_ADD]) ?>'">新規登録</button>
        <?php } ?>
        <button type="button" class="btn btn-flat btn-outline-secondary mr-2" data-toggle="modal" data-target="#charge_relations-search-form-modal">検索</button>
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_CSV_EXPORT])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_CSV_EXPORT, '?' => $this->getRequest()->getQueryParams()]) ?>'">CSVエクスポート</button>
        <?php } ?>
        <div class="freeword-search input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <?= $this->Form->control('search_snippet_format', ['type' => 'radio', 'options' => _code('Others.search_snippet_format'), 'class' => 'form-check-label col-form-label col-form-label-sm charge_relations-freeword-search-snippet-format', 'default' => 'AND', 'value' => @$params['search_snippet_format'], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}{{input}}<small><label {{attrs}}>{{text}}</label></small>', 'radioWrapper' => '{{label}}', 'inputContainer' => '{{content}}']]) ?>
            </div>
          </div>
          <?= $this->Form->text('search_snippet', ['id' => 'charge_relations-freeword-search-snippet', 'class' => 'form-control rounded-0', 'value' => @$params['search_snippet'], 'style' => 'width: 200px;', 'placeholder' => 'フリーワード']) ?>
          <div class="input-group-append">
            <button type="button" id="charge_relations-freeword-search-btn" class="btn btn-flat btn-outline-secondary"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'charge_relations-freeword-search-form', 'class' => 'd-none']) ?>
          <?= $this->Form->hidden('search_snippet', ['id' => 'charge_relations-freeword-hidden-search-snippet', 'value' => @$params['search_snippet']]) ?>
          <?= $this->Form->hidden('search_snippet_format', ['id' => 'charge_relations-freeword-hidden-search-snippet-format', 'value' => @$params['search_snippet_format']]) ?>
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
            <th scope="col"><?= $this->Paginator->sort('charge_id', '基本料金ID') ?></th>
            <th scope="col"><?= $this->Paginator->sort('charge_master_id', '料金マスタID') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified', '更新日時') ?></th>
            <th scope="col" class="actions">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($charge_relations as $charge_relation) { ?>
            <tr>
              <td><?= $this->Html->link($charge_relation->id, ['action' => ACTION_VIEW, $charge_relation->id]) ?></td>
              <td>
                <?= $charge_relation->has('charge') ? $this->Html->link($charge_relation->charge->name, ['controller' => 'Charges', 'action' => ACTION_VIEW, $charge_relation->charge->id]) : '' ?>
              </td>
              <td>
                <?= $charge_relation->has('charge_master') ? $this->Html->link($charge_relation->charge_master->name, ['controller' => 'ChargeMasters', 'action' => ACTION_VIEW, $charge_relation->charge_master->id]) : '' ?>
              </td>
              <td>
                <?php if (!is_null($charge_relation->modified)) { ?>
                  <?= h($charge_relation->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
                <?php } ?>
              </td>
              <td class="actions">
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop<?= $charge_relation->id ?>" type="button" class="btn btn-sm btn-flat btn-outline-secondary dropdown-toggle index-dropdown-toggle" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"></button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop<?= $charge_relation->id ?>">
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_VIEW])) { ?>
                      <?= $this->Html->link('詳細', ['action' => ACTION_VIEW, $charge_relation->id], ['class' => 'dropdown-item']) ?>
                    <?php } ?>
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_EDIT])) { ?>
                      <?= $this->Html->link('編集', ['action' => ACTION_EDIT, $charge_relation->id], ['class' => 'dropdown-item']) ?>
                    <?php } ?>
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_DELETE])) { ?>
                      <?= $this->Form->postLink('削除', ['action' => ACTION_DELETE, $charge_relation->id], ['class' => 'dropdown-item', 'confirm' => __('ID {0} を削除します。よろしいですか？', $charge_relation->id)]) ?>
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

<div class="modal search-form fade" id="charge_relations-search-form-modal" tabindex="-1" role="dialog" aria-labelledby="charge_relations-search-form-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">料金マッピング検索</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'charge_relations-search-form']) ?>
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
                <?= $this->Form->control('charge_id', ['id' => 'charge_id', 'type' => 'select', 'options' => $charges, 'class' => 'form-control', 'label' => '基本料金ID', 'value' => @$params['charge_id']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('charge_master_id', ['id' => 'charge_master_id', 'type' => 'select', 'options' => $chargeMasters, 'class' => 'form-control', 'label' => '料金マスタID', 'value' => @$params['charge_master_id']]); ?>
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

<?= $this->Html->script('admin/charge_relations_index', ['block' => true, 'charset' => 'UTF-8']) ?>
