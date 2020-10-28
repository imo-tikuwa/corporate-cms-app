<?php
$this->assign('title', "リンク集<span>Link</span>");
?>
<h3>ショップ関連<span>Shop relation</span></h3>
<div class="box_out">
  <div class="box_in">
    <?php if (!empty($shop_links)) foreach ($shop_links as $shop_link) { ?>
      <dl class="dl_link">
        <dt><a href="<?= $shop_link->url ?>"><?= $shop_link->title ?></a></dt>
        <dd><?= $shop_link->description ?></dd>
      </dl>
    <?php } ?>
  </div>
</div>
<div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="img/to_top.gif" alt="ページトップへ戻る" /></a></div>
<h3>その他<span>Etc</span></h3>
<div class="box_out">
  <div class="box_in">
    <?php if (!empty($other_links)) foreach ($other_links as $other_link) { ?>
      <dl class="dl_link">
        <dt><a href="<?= $other_link->url ?>"><?= $other_link->title ?></a></dt>
        <dd><?= $other_link->description ?></dd>
      </dl>
    <?php } ?>
  </div>
</div>