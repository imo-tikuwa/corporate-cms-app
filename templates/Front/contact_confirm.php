<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "お問い合わせ・ご相談<span>Reservation / Contact</span>");
?>
<h3>お問い合わせフォーム<span>Contact form</span></h3>
<div class="box_out">
  <div class="box_in">
    <div id="form">
      <?= $this->Form->create($form, ['type' => 'post']) ?>
        <?= $this->Form->hidden('mode', ['value' => 'confirm']) ?>
        <table class="table_info">
          <tr>
            <td class="td_head">お名前<span class="chui">*</span><br />
              <span class="eng">Your name</span>
            </td>
            <td class="td_odd">
              <?= @h($form_values['content1']) ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">メールアドレス<span class="chui">*</span><br />
              <span class="eng">E-mail address</span>
            </td>
            <td class="td_odd">
              <?= @h($form_values['content2']) ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">お問い合わせ内容<span class="chui">*</span><br />
              <span class="eng">Kind of question</span>
            </td>
            <td class="td_odd">
              <?= @h(_code('Codes.Contacts.type.'.$form_values['content3'])) ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">お電話番号<br />
              <span class="eng">Telephone number</span>
            </td>
            <td class="td_odd">
              <?= @h($form_values['content4']) ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">ご希望日時<br />
              その他ご要望等<span class="chui">*</span><br />
              <span class="eng">Content of question</span>
            </td>
            <td class="td_odd">
              <?= @nl2br(h($form_values['content5'])) ?>
            </td>
          </tr>
          <tr>
            <td class="td_head">ホームページURL<br />
              <span class="eng">Your homepage</span>
            </td>
            <td class="td_odd">
              <?= @h($form_values['content6']) ?>
            </td>
          </tr>
        </table>
        <div align="center">
          <input type="button" name="return" onclick="$('#return-to-input').submit();" value="　戻る　" />
          <input type="submit" name="submit" value="　送信する　" />
        </div>
        <?= $this->Form->hidden('token', ['value' => $token]); ?>
        <?= $this->Form->hidden('content1'); ?>
        <?= $this->Form->hidden('content2'); ?>
        <?= $this->Form->hidden('content3'); ?>
        <?= $this->Form->hidden('content4'); ?>
        <?= $this->Form->hidden('content5'); ?>
        <?= $this->Form->hidden('content6'); ?>
      <?= $this->Form->end() ?>
      <?= $this->Form->create(null, ['type' => 'post', 'id' => 'return-to-input']) ?>
        <?= $this->Form->hidden('mode', ['value' => 'return']) ?>
        <?= $this->Form->hidden('content1'); ?>
        <?= $this->Form->hidden('content2'); ?>
        <?= $this->Form->hidden('content3'); ?>
        <?= $this->Form->hidden('content4'); ?>
        <?= $this->Form->hidden('content5'); ?>
        <?= $this->Form->hidden('content6'); ?>
      <?= $this->Form->end() ?>
    </div>
    <p class="chui">※「*」マークは、必須項目です。</p>
  </div>
</div>