<?php
/**
 * @var \App\View\AppView $this
 */
$current_action = $this->request->getParam('action');
?>
<footer>
  <div class="prbox">
    <!--　削除禁止【ＰＲ枠】ここから　-->
    <!--prno.130321ver2.01set016-->
    Design by <a href="http://www.megapx.com/" title="ホームページデザイン：メガピクス" target="_blank">Megapx</a>　/　Template by <a href="http://www.s-hoshino.com/" title="テンプレート配布元：フリー素材屋Hoshino" target="_blank">s-hoshino.com</a>
    <!--　/削除禁止【ＰＲ枠】ここまで　-->
  </div>
  <?php if ($current_action != 'sitemap') { ?>
    <ul id="f_ul01">
      <?php foreach (_code('Front.FooterLinks') as $footer_link) { ?>
        <li><?= $this->Html->link($footer_link['link_html'], ['controller' => 'Front', 'action' => $footer_link['action']]) ?></li>
      <?php } ?>
    </ul>
    <ul id="f_ul02">
      <li><?= $this->Html->link('お問い合わせ・ご相談', ['controller' => 'Front', 'action' => 'contact']) ?></li>
      <li><?= $this->Html->link('採用情報', ['controller' => 'Front', 'action' => 'recruit']) ?></li>
      <li><?= $this->Html->link('サイトマップ', ['controller' => 'Front', 'action' => 'sitemap']) ?></li>
    </ul>
  <?php } ?>
  <div id="f_logo">Sample Site</div>
  <p>〒123-4567　見本県見本町1－2－34　サンプルビル5F<br />
    TEL:01-2345-6789 / FAX:01-2345-6789</p>
</footer>