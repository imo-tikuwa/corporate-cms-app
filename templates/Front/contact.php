<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "お問い合わせ・ご相談<span>Reservation / Contact</span>");
?>
<h3>お問い合わせフォーム<span>Contact form</span></h3>
<div class="box_out">
  <div class="box_in">
    <?= $this->Flash->render() ?>
    <div id="form">
      <?= $this->Form->create($form, ['type' => 'post']) ?>
        <?= $this->Form->hidden('mode', ['value' => 'input']) ?>
        <table class="table_info">
          <tr>
            <td class="td_head">お名前<span class="chui">*</span><br />
              <span class="eng">Your name</span>
            </td>
            <td class="td_odd">
              <?= $this->Form->control('content1', ['type' => 'text', 'label' => false, 'required' => false]); ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">メールアドレス<span class="chui">*</span><br />
              <span class="eng">E-mail address</span>
            </td>
            <td class="td_odd">
              <?= $this->Form->control('content2', ['type' => 'text', 'label' => false, 'size' => '50', 'required' => false]); ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">お問い合わせ内容<span class="chui">*</span><br />
              <span class="eng">Kind of question</span>
            </td>
            <td class="td_odd">
              <?= $this->Form->radio('content3', _code('Codes.Contacts.type'), ['required' => false]) ?>
              <?= $this->Form->error('content3') ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">お電話番号<br />
              <span class="eng">Telephone number</span>
            </td>
            <td class="td_odd">
              <?= $this->Form->control('content4', ['type' => 'text', 'label' => false, 'required' => false]); ?>
              <span class="chui">※ご予約の際はご記入をお願い致します。</span>
            </td>
          </tr>
          <tr>
            <td class="td_head">ご希望日時<br />
              その他ご要望等<span class="chui">*</span><br />
              <span class="eng">Content of question</span>
            </td>
            <td class="td_odd">
              <?= $this->Form->control('content5', ['type' => 'textarea', 'label' => false, 'rows' => '7', 'cols' => '50', 'required' => false]); ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">ホームページURL<br />
              <span class="eng">Your homepage</span>
            </td>
            <td class="td_odd">
              <?= $this->Form->control('content6', ['type' => 'text', 'label' => false, 'default' => 'http://', 'size' => '50', 'required' => false]); ?>
              <span class="chui">※相互リンクご希望の方はご記入をお願い致します。</span>
            </td>
          </tr>
        </table>
        <div align="center">
          <input type="submit" name="submit" value="　内容を確認する　" />
        </div>
      <?= $this->Form->end() ?>
    </div>
    <p class="chui">※「*」マークは、必須項目です。</p>
  </div>
</div>