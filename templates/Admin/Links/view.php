<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
$this->assign('title', "リンク集詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <table class="table table-hover table-borderless">
        <tr>
          <th scope="row">ID</th>
          <td><?= h($link->id) ?></td>
        </tr>
        <tr>
          <th scope="row">リンクカテゴリ</th>
          <td><?= @h(_code("Codes.Links.category.{$link->category}")) ?></td>
        </tr>
        <tr>
          <th scope="row">リンクタイトル</th>
          <td><?= h($link->title) ?></td>
        </tr>
        <tr>
          <th scope="row">リンクURL</th>
          <td><?= h($link->url) ?></td>
        </tr>
        <tr>
          <th scope="row">リンク説明</th>
          <td><?= nl2br(h($link->description)) ?></td>
        </tr>
        <tr>
          <th scope="row">作成日時</th>
          <td>
            <?php if (!is_null($link->created)) { ?>
              <?= h($link->created->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th scope="row">更新日時</th>
          <td>
            <?php if (!is_null($link->modified)) { ?>
              <?= h($link->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

