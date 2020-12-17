<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Charge $charge
 */
$this->assign('title', "基本料金詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <table class="table table-hover table-borderless">
        <tr>
          <th scope="row">ID</th>
          <td><?= h($charge->id) ?></td>
        </tr>
        <tr>
          <th scope="row">プラン名</th>
          <td><?= h($charge->name) ?></td>
        </tr>
        <tr>
          <th scope="row">プラン名下注釈</th>
          <td><?= h($charge->annotation) ?></td>
        </tr>
        <tr>
          <th scope="row">作成日時</th>
          <td><?= h($this->formatDate($charge->created, 'yyyy/MM/dd HH:mm:ss')) ?></td>
        </tr>
        <tr>
          <th scope="row">更新日時</th>
          <td><?= h($this->formatDate($charge->modified, 'yyyy/MM/dd HH:mm:ss')) ?></td>
        </tr>
      </table>
    </div>
  </div>
</div>

