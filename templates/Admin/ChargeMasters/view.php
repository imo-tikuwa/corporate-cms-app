<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChargeMaster $chargeMaster
 */
$this->assign('title', "料金マスタ詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <table class="table table-hover table-borderless">
        <tr>
          <th scope="row">ID</th>
          <td><?= h($chargeMaster->id) ?></td>
        </tr>
        <tr>
          <th scope="row">マスタ名</th>
          <td><?= h($chargeMaster->name) ?></td>
        </tr>
        <tr>
          <th scope="row">基本料金</th>
          <td><?= $this->Number->format($chargeMaster->basic_charge) ?>円</td>
        </tr>
        <tr>
          <th scope="row">キャンペーン料金</th>
          <td><?= $this->Number->format($chargeMaster->campaign_charge) ?>円</td>
        </tr>
        <tr>
          <th scope="row">作成日時</th>
          <td>
            <?php if (!is_null($chargeMaster->created)) { ?>
              <?= h($chargeMaster->created->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th scope="row">更新日時</th>
          <td>
            <?php if (!is_null($chargeMaster->modified)) { ?>
              <?= h($chargeMaster->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

