<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', "スタッフのご紹介<span>Staff</span>");
?>
<div id="mokuji">
  <h3>スタッフ一覧</h3>
  <ul>
    <?php foreach ($staffs as $index => $staff) { ?>
      <li><a href="#staff<?= $index ?>"><?= _code('Codes.Staffs.staff_position.'.$staff->staff_position)?>：<?= $staff->name ?></a></li>
    <?php } ?>
  </ul>
</div>

<?php foreach ($staffs as $index => $staff) { ?>
  <a name="staff<?= $index ?>" id="staff<?= $index ?>"></a>
  <h3><?= $staff->name ?><span><?= $staff->name_en ?></span></h3>
  <div class="box_out">
    <div class="box_in">
      <?php if ($staff->photo_position == '01') { ?>
        <div class="img_left"><img src="/upload_files/staffs/<?= $this->thumbPath($staff->photo[0]['cur_name']) ?>" alt="<?= $staff->name ?>" /></div>
      <?php } else if ($staff->photo_position == '02') { ?>
        <div class="img_right"><img src="/upload_files/staffs/<?= $this->thumbPath($staff->photo[0]['cur_name']) ?>" alt="<?= $staff->name ?>" /></div>
      <?php } ?>
      <?php if (!empty($staff->description1)) { ?><?= nl2br($staff->description1) ?><?php } ?>
      <?php if (!empty($staff->midashi1)) { ?><p><?= $staff->midashi1 ?></p><?php } ?>
      <?php if (!empty($staff->description2)) { ?><p><?= $staff->description2 ?></p><?php } ?>
    </div>
  </div>
  <?php if ($staff != end($staffs)) { ?>
    <div class="to_top"><a href="#" onclick="backToTop(); return false"><img src="/img/to_top.gif" alt="ページトップへ戻る" /></a></div>
  <?php } ?>
<?php } ?>