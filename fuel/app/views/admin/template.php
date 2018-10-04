<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?> | STAY MANAGER</title>
<meta name="description" content="">
<meta name="keywords" content="" >
<meta name="format-detection" content="telephone=no">
<?php echo Asset::css("reset.css"); ?>
<?php echo Asset::css("style.css"); ?>
<?php echo Asset::css("front/jqueryui.css"); ?>

<!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" > -->
<!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" > -->

<?php echo Asset::js("jquery-2.2.0.min.js"); ?>
<?php echo Asset::js("common.js"); ?>
<?php echo Asset::js($jsfile); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

</head>
<body class="plan">
<div id="wrapper">
<!-- header -->
<header>
<div class="inner">
<div class="accountBox clearfix">
<table>
<tr>
<td class="loginId"><?php echo $name; ?></td>
<td>

<?php echo Form::open('admin/index/logout');?>
<input type="submit" name="logOut" id="logOut" value="ログアウト">
<?php echo Form::close();?>

</td>
</tr>
</table>
</div>
</div>
<div class="headerNav">
<h1 class="logo"><?php echo Asset::img('logo02.png',array('alt' => 'STAY MANAGER')) ?></h1>
<nav>
<ul>
<li class="plan"><a href="/admin/plan"><span>宿泊プラン管理</span></a><ul>
<?php if($title == TITLE_PLAN) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/plan','宿泊プラン'); ?></li>
<?php if($title == TITLE_PRICE) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/price','料金管理'); ?></li>
<?php if($title == TITLE_ROOM) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/room','部屋タイプ'); ?></li>
<?php if($title == TITLE_STOCK) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/stock','在庫管理'); ?></li>
</ul></li>

<li class="reserve"><a href="/admin/reserve"><span>予約・顧客管理</span></a><ul>
<?php if($title == TITLE_RESERVATION) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/reserve','予約管理'); ?></li>
<?php if($title == TITLE_CSV) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/reserve/csv','予約CSV出力'); ?></li>

</ul></li>
<li class="config"><a href="/admin/setting"><span>各種設定</span></a><ul>
<?php if($title == TITLE_SETTING) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/setting','アカウント設定'); ?></li>
<?php if($title == TITLE_MAIL_SETTING) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/setting/mail','通知メール設定'); ?></li>
<?php if($title == TITLE_HOTEL_SETTING) {echo "<li class='current'>"; }else{echo "<li>";} echo Html::anchor('admin/setting/hotel','施設情報設定'); ?></li>

</ul></li>

</ul>
</nav>
</div>
</header>
    <div id="content">
        <?php echo $content; ?>
    </div>
<footer>
<div class="inner">
<div class="footerNav">
<nav>
<ul>
<li><a><?php echo Html::anchor('admin/plan','宿泊プラン管理'); ?></a>
<ul>
<li><?php echo Html::anchor('admin/plan','宿泊プラン'); ?></li>
<li><?php echo Html::anchor('admin/price','料金管理'); ?></li>
<li><?php echo Html::anchor('admin/room','部屋タイプ'); ?></li>
<li><?php echo Html::anchor('admin/stock','在庫管理'); ?></li>
</ul>
</li>

<li><a><?php echo Html::anchor('admin/reserve','予約・顧客管理'); ?></a>
<ul>
<li><?php echo Html::anchor('admin/reserve','予約管理'); ?></li>
<li><?php echo Html::anchor('admin/reserve/csv','予約CSV出力'); ?></li>
</ul>
</li>

<li><a><?php echo Html::anchor('admin/setting','各種設定'); ?></a>
<ul>
<li><?php echo Html::anchor('admin/setting','アカウント設定'); ?></li>
<li><?php echo Html::anchor('admin/setting/mail','通知メール設定'); ?></li>
<li><?php echo Html::anchor('admin/setting/hotel','施設情報設定'); ?></li>
</ul>
</li>

</ul>
</nav>
</div>
</div>
</footer>
</body>
</html>