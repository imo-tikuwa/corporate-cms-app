<!doctype html>
<html>
<head>
  <?= $this->element('front_html_head'); ?>
</head>
<body id="sitemap">

<div id="hp_base">
  <header>
    <?= $this->element('front_header'); ?>
  </header>
  <div id="main">
    <h2>サイトマップ<span>SiteMap</span></h2>
    <p>サイトマップのサンプルページです。<br />
      必要に応じて各項目を変更・追加・削除してお使いください。</p>
    <ul class="ul_sitemap">
      <li><?= $this->Html->link('トップページ', ['controller' => 'Front', 'action' => 'index']) ?></li>
      <li>
        <ul>
          <li><?= $this->Html->link('メニュー・料金', ['controller' => 'Front', 'action' => 'menu']) ?></li>
          <li><?= $this->Html->link('ギャラリー', ['controller' => 'Front', 'action' => 'works']) ?></li>
          <li><?= $this->Html->link('スタッフ紹介', ['controller' => 'Front', 'action' => 'staff']) ?></li>
          <li><?= $this->Html->link('店舗案内', ['controller' => 'Front', 'action' => 'shop']) ?></li>
          <li><?= $this->Html->link('アクセスマップ', ['controller' => 'Front', 'action' => 'access']) ?></li>
          <li><?= $this->Html->link('リンク集', ['controller' => 'Front', 'action' => 'link']) ?></li>
        </ul>
      </li>
    </ul>
    <ul class="ul_sitemap">
      <li><?= $this->Html->link('お問い合わせ・ご相談', ['controller' => 'Front', 'action' => 'contact']) ?></li>
      <li><?= $this->Html->link('採用情報', ['controller' => 'Front', 'action' => 'recruit']) ?></li>
    </ul>
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