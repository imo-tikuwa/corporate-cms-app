<?php
/**
 * @var \App\View\AppView $this
 */
$front_title = @_code('Front.HtmlHeadTitles.' . $this->request->getParam('action'));
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
<title><?php if (!empty($front_title)) { ?><?= $front_title ?>　<?php } ?>レスポンシブHPテンプレート no.005</title>
<meta name="Keywords" content="ショップ,店舗,キーワード01,キーワード02,キーワード03" />
<meta name="Description" content="リンク集。レスポンシブHPテンプレート no.005。ここにページの説明文を入れます。" />
<link href="/style.css" rel="stylesheet" media="all" type="text/css" />

<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script src="/js/jquery-2.0.2.min.js"></script>
<script src="/js/js.js"></script>