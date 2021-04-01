<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Charge $charge
 * @var \App\Model\Entity\ChargeDetail[] $charge_details
 */
$this->assign('title', "料金詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
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
          <?php if (!is_null($charge->charge_details) && count($charge->charge_details) > 0) { ?>
            <tr>
              <th scope="row">料金詳細</th>
              <td>
                <div class="table-responsive">
                  <table class="table table-hover table-borderless">
                    <tr>
                      <th scope="row">料金名</th>
                      <th scope="row">基本料金</th>
                      <th scope="row">キャンペーン料金</th>
                    </tr>
                    <?php /** @var \App\Model\Entity\ChargeDetail $charge_detail */ ?>
                    <?php foreach ($charge->charge_details as $charge_detail) { ?>
                      <tr>
                        <td scope="row"><?= h($charge_detail->name) ?></td>
                        <td scope="row"><?= $this->Number->format($charge_detail->basic_charge) ?>円</td>
                        <td scope="row"><?= $this->Number->format($charge_detail->campaign_charge) ?>円</td>
                      </tr>
                    <?php } ?>
                  </table>
                </div>
              </td>
            </tr>
          <?php } ?>
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
</div>

