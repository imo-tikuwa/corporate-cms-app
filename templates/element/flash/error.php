<?php
/**
 * @var \App\View\AppView $this
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
  $message = h($message);
}

if ($this->name == 'Front') { ?>
  <p class="error-message"><?= $message ?></p>
<?php } else { ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?= $message ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>