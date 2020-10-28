<?php
/**
 * @var \App\View\AppView $this
 */
$front_breadcrumb = @_code('Front.Breadcrumbs.' . $this->request->getParam('action'));
if (!is_null($front_breadcrumb)) {
?>
  <div id="pankuzu"><?= $this->Html->link('トップページ', ['controller' => 'Front', 'action' => 'index']) ?>　＞　<strong><?= $front_breadcrumb ?></strong></div>
<?php
}
?>