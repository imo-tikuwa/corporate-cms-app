<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "アクセスマップ<span>Access map</span>");
?>
<h3>アクセス方法<span>Access</span></h3>
<div class="box_out">
  <div class="box_in">
  <?php if (!empty($access_map->description)) { ?><p><?= $access_map->description ?></p><?php } ?>
  <div class="map_base">
    <iframe width="600" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?output=embed&q=<?= h($access_map->location['latitude']) ?>,<?= h($access_map->location['longitude']) ?>&z=<?= h($access_map->location['zoom']) ?>"></iframe><br />
    <?php if (!empty($access_map->map_link)) { ?>
      <small><a href="<?= $access_map->map_link ?>">大きな地図で見る</a></small>
    <?php } ?>
  </div>
  </div>
</div>