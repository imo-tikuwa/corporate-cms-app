<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeRelation $chargeRelation
 */
$this->assign('title', "料金マッピング詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <table class="table table-hover table-borderless">
        <tr>
          <th scope="row">ID</th>
          <td><?= h($chargeRelation->id) ?></td>
        </tr>
        <tr>
          <th scope="row">基本料金ID</th>
          <td><?= $chargeRelation->has('charge') ? $chargeRelation->charge->name : '' ?></td>
        </tr>
        <tr>
          <th scope="row">料金マスタID</th>
          <td><?= $chargeRelation->has('charge_master') ? $chargeRelation->charge_master->name : '' ?></td>
        </tr>
        <tr>
          <th scope="row">作成日時</th>
          <td>
            <?php if (!is_null($chargeRelation->created)) { ?>
              <?= h($chargeRelation->created->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th scope="row">更新日時</th>
          <td>
            <?php if (!is_null($chargeRelation->modified)) { ?>
              <?= h($chargeRelation->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

