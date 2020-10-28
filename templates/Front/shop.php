<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "店舗のご案内<span>Information</span>");
?>
<div id="mokuji">
  <h3>ページ内サンプル目次</h3>
  <ul>
    <li><a href="#info01">店舗情報</a></li>
    <li><a href="#info02">代表ご挨拶</a></li>
    <li><a href="#info03">会社概要</a></li>
    <li><a href="#info04">会社沿革</a></li>
  </ul>
</div>
<a name="info01" id="info01"></a>
<h3>店舗情報<span>Information</span></h3>
<div class="box_out">
  <div class="box_in">
    <table class="table_info">
      <tr>
        <td class="td_head">店舗名</td>
        <td class="td_odd">Sample Site</td>
      </tr>
      <tr>
        <td class="td_head">営業時間</td>
        <td class="td_odd">平日：11：00～21：00<br /> <span class="chui">（最終受付20：00、電話予約19：00まで）</span><br /> 土・日・祝　11：00～20：00<br /> <span class="chui">（最終受付19：00、電話予約18：00まで）</span></td>
      </tr>
      <tr>
        <td class="td_head">定休日</td>
        <td class="td_odd">月曜・火曜・年末年始</td>
      </tr>
      <tr>
      <tr>
        <td class="td_head">アクセス</td>
        <td class="td_odd">ＪＲ見本線サンプル駅西口より徒歩５分<br /> <?= $this->Html->link('＞＞アクセス方法の詳細はコチラ', ['controller' => 'Front', 'action' => 'access']) ?></td>
      </tr>
      <tr>
        <td class="td_head">所在地</td>
        <td class="td_odd">〒123-4567　見本県見本町1－2－34　サンプルビル5F</td>
      </tr>
      <tr>
        <td class="td_head">お問い合わせ・ご相談</td>
        <td class="td_odd"><?= $this->Html->link('お問い合わせフォーム', ['controller' => 'Front', 'action' => 'contact']) ?>より24時間受付中です<br /> お電話によるお問い合わせ：0120-123-456</td>
      </tr>
      <tr>
        <td class="td_head">ＵＲＬ</td>
        <td class="td_odd">http://www.samplesample.jp</td>
      </tr>
    </table>
  </div>
</div>
<div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="/img/to_top.gif" alt="ページトップへ戻る" /></a></div> <a name="info02" id="info02"></a>
<h3>代表ご挨拶<span>Message</span></h3>
<div class="box_out">
  <div class="box_in">
    <div class="img_left"><img src="/img/sample_l.jpg" alt="サンプルイメージ" /></div>
    <p>イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。</p>
    <p>イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。<br /> イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。</p>
    <div class="syomei">山田 花子</div>
  </div>
</div>
<div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="/img/to_top.gif" alt="ページトップへ戻る" /></a></div> <a name="info03" id="info03"></a>
<h3>会社概要<span>Company profile</span></h3>
<div class="box_out">
  <div class="box_in">
    <table class="table_info">
      <tr>
        <td class="td_head">名　称</td>
        <td class="td_odd">株式会社サンプルカンパニー</td>
      </tr>
      <tr>
        <td class="td_head">代表者</td>
        <td class="td_odd">山田 花子</td>
      </tr>
      <tr>
        <td class="td_head">事業内容</td>
        <td class="td_odd">イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。<br /> イメージ確認用のサンプル文言になります。任意のテキストに置き換えてお使いください。</td>
      </tr>
      <tr>
        <td class="td_head">所在地</td>
        <td class="td_odd">〒123-4567　見本県見本町1－2－34　サンプルビル5F</td>
      </tr>
      <tr>
        <td class="td_head">電話番号</td>
        <td class="td_odd">01-2345-6789</td>
      </tr>
      <tr>
        <td class="td_head">ＦＡＸ</td>
        <td class="td_odd">01-2345-6789</td>
      </tr>
      <tr>
        <td class="td_head">ＵＲＬ</td>
        <td class="td_odd">http://www.samplesample.jp</td>
      </tr>
      <tr>
        <td class="td_head">メールアドレス</td>
        <td class="td_odd">info@samplesample.jp</td>
      </tr>
    </table>
  </div>
</div>
<div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="/img/to_top.gif" alt="ページトップへ戻る" /></a></div> <a name="info04" id="info04"></a>
<h3>会社沿革<span>H3サンプル大見出し</span></h3>
<div class="box_out">
  <div class="box_in">
    <div class="dl_list">
      <dl>
        <dt>2011.05.01</dt>
        <dd>サンプルカンパニー設立</dd>
      </dl>
      <dl>
        <dt>2011.06.01</dt>
        <dd><a href="#">新規サンプルプロジェクトＡを開始。</a></dd>
      </dl>
      <dl>
        <dt>2011.06.30</dt>
        <dd><a href="#">新規サンプルプロジェクトＢを開始。</a></dd>
      </dl>
      <dl>
        <dt>2011.07.15</dt>
        <dd><a href="#">新規サンプルプロジェクトＣを開始。</a></dd>
      </dl>
      <dl>
        <dt>2011.08.01</dt>
        <dd><a href="#">新規サンプルプロジェクトＤを開始。</a></dd>
      </dl>
    </div>
    <br clear="all" />
  </div>
</div>