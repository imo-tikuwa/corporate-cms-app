<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
$this->assign('title', "お問い合わせ情報詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-borderless">
          <tr>
            <th scope="row">ID</th>
            <td><?= h($contact->id) ?></td>
          </tr>
          <tr>
            <th scope="row">お名前</th>
            <td><?= h($contact->name) ?></td>
          </tr>
          <tr>
            <th scope="row">メールアドレス</th>
            <td><?= h($contact->email) ?></td>
          </tr>
          <tr>
            <th scope="row">お問い合わせ内容</th>
            <td><?= @h(_code("Codes.Contacts.type.{$contact->type}")) ?></td>
          </tr>
          <tr>
            <th scope="row">お電話番号</th>
            <td><?= h($contact->tel) ?></td>
          </tr>
          <tr>
            <th scope="row">ご希望日時／その他ご要望等</th>
            <td><?= nl2br(h($contact->content)) ?></td>
          </tr>
          <tr>
            <th scope="row">ホームページURL</th>
            <td><?= h($contact->hp_url) ?></td>
          </tr>
          <tr>
            <th scope="row">作成日時</th>
            <td><?= h($this->formatDate($contact->created, 'yyyy/MM/dd HH:mm:ss')) ?></td>
          </tr>
          <tr>
            <th scope="row">更新日時</th>
            <td><?= h($this->formatDate($contact->modified, 'yyyy/MM/dd HH:mm:ss')) ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

