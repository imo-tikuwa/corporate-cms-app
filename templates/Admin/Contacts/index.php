<?php
use App\Utils\AuthUtils;

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact[] $contacts
 */
$this->assign('title', "お問い合わせ情報");
$this->Form->setTemplates([
  'label' => '<label class="col-form-label"{{attrs}}>{{text}}</label>',
  'nestingLabel' => '{{hidden}}{{input}}<label class="form-check-label col-form-label" {{attrs}}>{{text}}</label>'
]);
?>
<div class="col-md-12 mb-12">
  <div class="card rounded-0">
    <div class="card-header">
      <div class="form-inline">
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_ADD])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_ADD]) ?>'">新規登録</button>
        <?php } ?>
        <button type="button" class="btn btn-flat btn-outline-secondary mr-2" data-toggle="modal" data-target="#contacts-search-form-modal">検索</button>
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_CSV_EXPORT])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_CSV_EXPORT, '?' => $this->getRequest()->getQueryParams()]) ?>'">CSVエクスポート</button>
        <?php } ?>
        <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_EXCEL_EXPORT])) { ?>
          <button type="button" class="btn btn-flat btn-outline-secondary mr-2" onclick="location.href='<?= $this->Url->build(['action' => ACTION_EXCEL_EXPORT, '?' => $this->getRequest()->getQueryParams()]) ?>'">Excelエクスポート</button>
        <?php } ?>
        <div class="freeword-search input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <?= $this->Form->control('search_snippet_format', ['type' => 'radio', 'options' => _code('Others.search_snippet_format'), 'class' => 'form-check-label col-form-label col-form-label-sm contacts-freeword-search-snippet-format', 'default' => 'AND', 'value' => @$params['search_snippet_format'], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}{{input}}<small><label {{attrs}}>{{text}}</label></small>', 'radioWrapper' => '{{label}}', 'inputContainer' => '{{content}}']]) ?>
            </div>
          </div>
          <?= $this->Form->text('search_snippet', ['id' => 'contacts-freeword-search-snippet', 'class' => 'form-control rounded-0', 'value' => @$params['search_snippet'], 'style' => 'width: 200px;', 'placeholder' => 'フリーワード']) ?>
          <div class="input-group-append">
            <button type="button" id="contacts-freeword-search-btn" class="btn btn-flat btn-outline-secondary"><i class="fas fa-search"></i></button>
          </div>
        </div>
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'contacts-freeword-search-form', 'class' => 'd-none']) ?>
          <?= $this->Form->hidden('search_snippet', ['id' => 'contacts-freeword-hidden-search-snippet', 'value' => @$params['search_snippet']]) ?>
          <?= $this->Form->hidden('search_snippet_format', ['id' => 'contacts-freeword-hidden-search-snippet-format', 'value' => @$params['search_snippet_format']]) ?>
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
            <th scope="col"><?= $this->Paginator->sort('name', 'お名前') ?></th>
            <th scope="col"><?= $this->Paginator->sort('email', 'メールアドレス') ?></th>
            <th scope="col"><?= $this->Paginator->sort('type', 'お問い合わせ内容') ?></th>
            <th scope="col"><?= $this->Paginator->sort('tel', 'お電話番号') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified', '更新日時') ?></th>
            <th scope="col" class="actions">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contacts as $contact) { ?>
            <tr>
              <td><?= $this->Html->link($contact->id, ['action' => ACTION_VIEW, $contact->id]) ?></td>
              <td><?= h($contact->name) ?></td>
              <td><?= h($contact->email) ?></td>
              <td><?= @h(_code("Codes.Contacts.type.{$contact->type}")) ?></td>
              <td><?= h($contact->tel) ?></td>
              <td>
                <?php if (!is_null($contact->modified)) { ?>
                  <?= h($contact->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
                <?php } ?>
              </td>
              <td class="actions">
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop<?= $contact->id ?>" type="button" class="btn btn-sm btn-flat btn-outline-secondary dropdown-toggle index-dropdown-toggle" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"></button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop<?= $contact->id ?>">
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_VIEW])) { ?>
                      <?= $this->Html->link('詳細', ['action' => ACTION_VIEW, $contact->id], ['class' => 'dropdown-item']) ?>
                    <?php } ?>
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_EDIT])) { ?>
                      <?= $this->Html->link('編集', ['action' => ACTION_EDIT, $contact->id], ['class' => 'dropdown-item']) ?>
                    <?php } ?>
                    <?php if (AuthUtils::hasRole($this->getRequest(), ['action' => ACTION_DELETE])) { ?>
                      <?= $this->Form->postLink('削除', ['action' => ACTION_DELETE, $contact->id], ['class' => 'dropdown-item', 'confirm' => __('ID {0} を削除します。よろしいですか？', $contact->id)]) ?>
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

<div class="modal search-form fade" id="contacts-search-form-modal" tabindex="-1" role="dialog" aria-labelledby="contacts-search-form-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">お問い合わせ情報検索</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'contacts-search-form']) ?>
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
                <?= $this->Form->control('name', ['class' => 'form-control rounded-0', 'label' => 'お名前', 'value' => @$params['name']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('email', ['class' => 'form-control rounded-0', 'label' => 'メールアドレス', 'value' => @$params['email']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <label class="d-block col-form-label">お問い合わせ内容</label>
                <?= $this->Form->control("type", ["type" => "radio", "options" => _code('Codes.Contacts.type'), "label" => false, 'value' => @$params['type'], "hiddenField" => false]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('tel', ['class' => 'form-control rounded-0', 'label' => 'お電話番号', 'value' => @$params['tel']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('content', ['class' => 'form-control rounded-0', 'label' => 'ご希望日時／その他ご要望等', 'value' => @$params['content']]); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="form-group">
                <?= $this->Form->control('hp_url', ['class' => 'form-control rounded-0', 'label' => 'ホームページURL', 'value' => @$params['hp_url']]); ?>
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

<?= $this->Html->script('admin/contacts_index', ['block' => true, 'charset' => 'UTF-8']) ?>
