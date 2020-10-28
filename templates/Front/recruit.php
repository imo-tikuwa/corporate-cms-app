<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "採用情報<span>Recruit</span>");
?>
<p>採用情報のサンプルページです。<br />
  必要に応じて各項目を変更・追加・削除してお使いください。</p>
<h3>募集要項<span>Adoption outline</span></h3>
<div class="box_out">
  <div class="box_in">
    <table class="table_info">
      <tr>
        <td class="td_head">募集職種</td>
        <td class="td_odd">アシスタント</td>
      </tr>
      <tr>
        <td class="td_head">応募資格</td>
        <td class="td_odd">20才～35才くらいまで<br />
          経験者優遇</td>
      </tr>
      <tr>
        <td class="td_head">待　遇</td>
        <td class="td_odd">賞与年2回　昇給あり　交通費全額支給</td>
      </tr>
      <tr>
        <td class="td_head">休日／休暇</td>
        <td class="td_odd">週休2日制（月曜・火曜定休）／夏季・冬季</td>
      </tr>
      <tr>
        <td class="td_head">勤務地</td>
        <td class="td_odd">ＪＲ見本線サンプル駅西口より徒歩５分<br />
          〒123-4567　見本県見本町1－2－34　サンプルビル5F</td>
      </tr>
      <tr>
        <td class="td_head">選考方法</td>
        <td class="td_odd">書類選考後、面接</td>
      </tr>
      <tr>
        <td class="td_head">応募・お問い合わせ</td>
        <td class="td_odd"><?= $this->Html->link('お問い合わせフォーム', ['controller' => 'Front', 'action' => 'contact']) ?>より24時間受付中です<br />
          お電話による応募：0120-123-456</td>
      </tr>
    </table>
  </div>
</div>