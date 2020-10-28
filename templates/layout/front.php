<?php
/**
 * @var \App\View\AppView $this
 */
$current_action = $this->request->getParam('action');
?>
<!doctype html>
<html>
<head>
  <?= $this->element('front_html_head'); ?>
</head>
<body>
<div id="hp_base">

  <header>
    <?= $this->element('front_header'); ?>
  </header>
  <div id="main">
    <?php if ($current_action === 'index') { ?>
      <div id="top_img">
        <div class="top_txt">
          最適な空間をご提案いたします<br>
          <span>We propose the optimal home for you. </span>
        </div>
        <img src="/img/top_img.jpg" alt="メインイメージ" />
      </div>
    <?php } ?>
    <?= $this->element('front_breadcrumb'); ?>
    <?php if ($current_action != 'index') { ?>
      <h2><?= $this->fetch('title') ?></h2>
    <?php } ?>
    <div id="content">
      <?= $this->fetch('content') ?>
      <div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="/img/to_top.gif" alt="ページトップへ戻る" /></a></div>
    </div>
    <!--/content end-->

    <div id="side">
      <?= $this->element('front_side_menu'); ?>
    </div>
    <!--/side end-->
  </div>
  <!--/main end-->
</div>
<!--/base end-->

<div id="foot_base">
  <?= $this->element('front_footer'); ?>
  <address>
  Copyright(C) レスポンシブHPテンプレート no.005 All Rights Reserved.
  </address>
</div>
<!--/footer end-->
</body>
</html>