<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "メニュー・料金<span>Menu / Price</span>");
?>
<h3>基本料金一覧<span>Basic charge list</span></h3>
<div class="box_out">
  <div class="box_in">
    <p>現在キャンペーン実施中です。<br />
      <span class="chui">(キャンペーン期間：20××年3月1日～5月31日まで)</span></p>
    <div class="menu_base">
      <table class="table_menu">
        <?php foreach ($charges as $charge) { ?>
          <tr>
            <th>
              <?= $charge->name ?>
              <?php if (!empty($charge->annotation)) { ?><br /><span><?= $charge->annotation ?></span><?php } ?>
            </th>
            <td>
              <?php foreach ($charge->charge_relations as $charge_relation) { ?>
                <?php
                if (!isset($charge_relation->charge_master) || empty($charge_relation->charge_master)) {
                  continue;
                }
                ?>
                <?php if (!empty($charge_relation->charge_master->name)) { ?><?= $charge_relation->charge_master->name ?>：<?php } ?><span class="teisei"><?= number_format($charge_relation->charge_master->basic_charge) ?>円</span>→<strong><?= number_format($charge_relation->charge_master->campaign_charge) ?>円</strong>
                <?php if ($charge_relation != end($charge->charge_relations)) { ?>
                  <br />
                <?php } ?>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
    <p align="right"><span class="chui">※橙文字がキャンペーン価格となっております。</span></p>
    <div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="/img/to_top.gif" alt="ページトップへ戻る" /></a></div>
  </div>
</div>