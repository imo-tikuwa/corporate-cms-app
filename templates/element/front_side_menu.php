<?php
/**
 * @var \App\View\AppView $this
 */
?>
      <div class="side_box">
        <div class="side_btn"><a href="<?= $this->Url->build(['controller' => 'Front', 'action' => 'contact']) ?>"><img src="/img/side_btn.jpg" alt="お問い合わせ・ご予約はコチラ" /></a></div>
      </div>
      <h3>SITE MENU</h3>
      <div class="side_box">
        <div class="side_inbox">
          <ul>
            <?php foreach (_code('Front.SideMenus') as $side_menu) { ?>
              <li><?= $this->Html->link($side_menu['link_html'], ['controller' => 'Front', 'action' => $side_menu['action']], ['escape' => false]) ?></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <div class="side_box">
        <h3>NEWS</h3>
        <div class="side_inbox">
          <p><a href="#">今年流行の最新メニューを追加いたしました！</a><span class="chui">NEW!</span></p>
          <p><a href="#">お得なキャンペーン実施中です！</a></p>
        </div>
      </div>