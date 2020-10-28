<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
$this->assign('title', "スタッフ詳細");
?>
<div class="col-md-12 mb-12">
  <div class="card">
    <div class="card-body">
      <table class="table table-hover table-borderless">
        <tr>
          <th scope="row">ID</th>
          <td><?= h($staff->id) ?></td>
        </tr>
        <tr>
          <th scope="row">スタッフ名</th>
          <td><?= h($staff->name) ?></td>
        </tr>
        <tr>
          <th scope="row">スタッフ名(英)</th>
          <td><?= h($staff->name_en) ?></td>
        </tr>
        <tr>
          <th scope="row">スタッフ役職</th>
          <td><?= @h(_code("Codes.Staffs.staff_position.{$staff->staff_position}")) ?></td>
        </tr>
        <tr>
          <th scope="row">画像表示位置</th>
          <td><?= @h(_code("Codes.Staffs.photo_position.{$staff->photo_position}")) ?></td>
        </tr>
        <tr>
          <th scope="row">スタッフ画像</th>
          <td>
            <?php if (!empty($staff->photo)) foreach ($staff->photo as $each_data) { ?>
              <a href="/<?= UPLOAD_FILE_BASE_DIR_NAME ?>/staffs/<?= h($each_data['cur_name']) ?>" download="<?= h($each_data['org_name']) ?>"><?= h($each_data['org_name']) ?></a>
              <?php if ($each_data != end($staff->photo)) { ?><br /><?php } ?>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th scope="row">スタッフ説明1</th>
          <td><?= nl2br(h($staff->description1)) ?></td>
        </tr>
        <tr>
          <th scope="row">見出し1</th>
          <td><?= h($staff->midashi1) ?></td>
        </tr>
        <tr>
          <th scope="row">スタッフ説明2</th>
          <td><?= nl2br(h($staff->description2)) ?></td>
        </tr>
        <tr>
          <th scope="row">作成日時</th>
          <td>
            <?php if (!is_null($staff->created)) { ?>
              <?= h($staff->created->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <th scope="row">更新日時</th>
          <td>
            <?php if (!is_null($staff->modified)) { ?>
              <?= h($staff->modified->i18nFormat('yyyy/MM/dd HH:mm:ss')) ?>
            <?php } ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

