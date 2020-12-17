<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeRelation $charge_relation
 */
$this->assign('title', "料金マッピング詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <table class="table table-hover table-borderless">
        <tr>
          <th scope="row">ID</th>
          <td><?= h($charge_relation->id) ?></td>
        </tr>
        <tr>
          <th scope="row">基本料金ID</th>
          <td><?= $charge_relation->has('charge') ? h($charge_relation->charge->name) : '' ?></td>
        </tr>
        <tr>
          <th scope="row">料金マスタID</th>
          <td><?= $charge_relation->has('charge_master') ? h($charge_relation->charge_master->name) : '' ?></td>
        </tr>
        <tr>
          <th scope="row">作成日時</th>
          <td><?= h($this->formatDate($charge_relation->created, 'yyyy/MM/dd HH:mm:ss')) ?></td>
        </tr>
        <tr>
          <th scope="row">更新日時</th>
          <td><?= h($this->formatDate($charge_relation->modified, 'yyyy/MM/dd HH:mm:ss')) ?></td>
        </tr>
      </table>
    </div>
  </div>
</div>

