<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeMaster $charge_master
 */
$this->assign('title', "料金マスタ詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-borderless">
          <tr>
            <th scope="row">ID</th>
            <td><?= h($charge_master->id) ?></td>
          </tr>
          <tr>
            <th scope="row">マスタ名</th>
            <td><?= h($charge_master->name) ?></td>
          </tr>
          <tr>
            <th scope="row">基本料金</th>
            <td><?= $this->Number->format($charge_master->basic_charge) ?>円</td>
          </tr>
          <tr>
            <th scope="row">キャンペーン料金</th>
            <td><?= $this->Number->format($charge_master->campaign_charge) ?>円</td>
          </tr>
          <tr>
            <th scope="row">作成日時</th>
            <td><?= h($this->formatDate($charge_master->created, 'yyyy/MM/dd HH:mm:ss')) ?></td>
          </tr>
          <tr>
            <th scope="row">更新日時</th>
            <td><?= h($this->formatDate($charge_master->modified, 'yyyy/MM/dd HH:mm:ss')) ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

