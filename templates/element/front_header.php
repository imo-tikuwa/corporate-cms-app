<?php
/**
 * @var \App\View\AppView $this
 */
$current_action = $this->request->getParam('action');
?>
<h1>レスポンシブHPテンプレート no.005</h1>
<a href="<?= $this->Url->build(['controller' => 'Front', 'action' => 'index']) ?>" title="レスポンシブHPテンプレート no.005　トップページへ">
  <img src="/img/logo.gif" alt="レスポンシブHPテンプレート no.005　ロゴ" id="logo" />
</a>
<div id="info">お問い合わせ・ご相談はお気軽にどうぞ<br /><span>Tel.</span><strong>0120-123-456</strong></div>
<?php if ($current_action != 'sitemap') { ?>
  <ul id="h_list">
    <li><?= $this->Html->link('お問い合わせ・ご相談', ['controller' => 'Front', 'action' => 'contact']) ?></li>
    <li><?= $this->Html->link('採用情報', ['controller' => 'Front', 'action' => 'recruit']) ?></li>
    <li><?= $this->Html->link('サイトマップ', ['controller' => 'Front', 'action' => 'sitemap']) ?></li>
  </ul>
  <nav id="g_navi">
    <a class="menu">メニュー一覧<span></span></a>
    <ul class="gl_menu">
      <?php foreach (_code('Front.GlobalNavigations') as $front_gnavi) { ?>
        <?php if ($front_gnavi['action'] === $current_action) { ?>
          <li><strong><?= $front_gnavi['link_html'] ?></strong></li>
        <?php } else { ?>
          <li><?= $this->Html->link($front_gnavi['link_html'], ['controller' => 'Front', 'action' => $front_gnavi['action']], ['escape' => false]) ?></li>
        <?php } ?>
      <?php } ?>
    </ul>
  </nav>
<?php } ?>
