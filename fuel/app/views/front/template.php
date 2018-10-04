<!DOCTYPE html>
<html lang="<?php echo __('use_lang');?>">
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>
<!--[if lt IE 8]>
<meta http-equiv=”X-UA-Compatible” content=”IE=EmulateIE7; IE=EmulateIE9″/>
<![endif]-->
<meta name="description" content="THE TRAVELERS HUB - 世界を旅する人と人、 心と心をつなぐハブ・ホステル。">
<meta name="keywords" content="GRIDS, Hotel, Hostel, Japan, Tokyo, Akihabara, グリッズ, ホテル, ホステル, ゲストハウス, 東京, 秋葉原" >
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta property="og:title" content="グリッズ秋葉原（GRIDS Akihabara）｜秋葉原のホテル"/>
<meta property="og:description" content="THE TRAVELERS HUB - 世界を旅する人と人、 心と心をつなぐハブ・ホステル。" />
<meta property="og:image" content="" />
<!-- <link rel="shortcut icon" href="favicon.ico" > -->
<?php 
echo html_tag('link', array(
    'rel' => 'icon',
    'href' => Asset::get_file('front/icon.png', 'img'),
));
?>

<?php echo Asset::css("front/reset.css"); ?>
<?php echo Asset::css("front/jqueryui.css"); ?>
<?php echo Asset::css("front/style.css"); ?>
<?php echo Asset::js("front/jquery-2.2.0.min.js"); ?>
<?php echo Asset::js("front/jquery.colorbox-min.js"); ?>
<?php echo Asset::js("front/google-calendar-holidays.js"); ?>

<?php echo Asset::js("front/jquery.bxslider.js"); ?>
<?php echo Asset::js("front/common.js"); ?>
<?php echo Asset::js($js); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-<?php echo __('lbl_js_datepicker');?>.min.js"></script>
<?php echo Asset::js("front/google-calendar-holidays.js"); ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NSQ5PPF');</script>
<!-- End Google Tag Manager -->

</head>
<body id="reserve" class="akihabara<?php if(__('use_lang')=='en') echo ' eng_page'; ?>">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NSQ5PPF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="wrapper">

<!-- header -->
<header>
<div class="inner clearfix">
<div class="leftBox">
<p class="spHide"><?php echo __('lbl_htl_title');?></p>
<h1 class="imgSet"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>"><?php echo Asset::img('front/logo.png',array('alt' => 'GRIDS AKIHABARA')); ?></a></h1>
</div>
<div class="rightBox spHide">
<ul class="gnav01">
<li class="nav01"><a href="https://grids-hostel.com/<?php echo Helper_Common::grids_lang(__('use_lang'), false); ?>.html">CONCEPT</a></li>
<li class="nav02"><a href="https://grids-hostel.com/hostels/nihonbashi-east/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>">NIHOMBASHI-EAST</a></li>
<li class="nav03"><?php echo "<a href='".HTTP."/akihabara/language/ja'>"; ?>JP</a>／<?php echo "<a href='".HTTP."/akihabara/language/en'>"; ?>EN</a>
／<a href="<?php echo HTTP."/akihabara/language/ko" ?>">한국어</a>／<a href="<?php echo HTTP."/akihabara/language/tw" ?>">中文（繁体）</a>／<a href="<?php echo HTTP."/akihabara/language/ch" ?>">中文（簡体）</a>
</li>
</ul>
<ul class="gnav02 clearfix">
<li class="nav04"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>room.html">ROOM<span><?php echo __('lbl_rooms');?></span></a></li>
<li class="nav08"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>facility.html">FACILITY<span><?php echo __('lbl_facility');?></span></a></li>
<li class="nav05"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>cafe.html">CAFE<span><?php echo __('lbl_cafe');?></span></a></li>
<li class="nav06"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>access.html">ACCESS<span><?php echo __('lbl_access');?></span></a></li>
<?php if(isset($mypage_flg)){
  echo "<li class='nav07'><a href='".HTTP."/akihabara/plan'>RESERVATION<span>".__('lbl_reservation')."</span></a></li>";
}else{
  echo "<li class='nav07'><a href='".HTTP."/akihabara/mypage'>MYPAGE<span>".__('lbl_mypage')."</span></a></li>";
  }?>
</ul>
</div>

<div class="rightBox pcHide">
<p class="spReserve" style="visibility:hidden;"><a href="http://gridsakiba.rwiths.net/r-withs/tfs0010a.do" target="_blank"><?php echo Asset::img('front/reserve_sp.png',array('alt' => 'RESERVATION')); ?></a></p>
<p class="spMenu"><?php echo Asset::img('front/menu_sp.png',array('alt' => 'MENU')); ?></p>
</div>
<ul class="spGnav pcHide">
<li class="nav01"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>room.html">ROOM<span><?php echo __('lbl_rooms');?></span></a></li>
<li class="nav09"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>facility.html">FACILITY<span><?php echo __('lbl_facility');?></span></a></li>
<li class="nav02"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>cafe.html">CAFE<span><?php echo __('lbl_cafe');?></span></a></li>
<li class="nav03"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>access.html">ACCESS<span><?php echo __('lbl_access');?></span></a></li>
<?php if(isset($mypage_flg)): ?>
<li class="nav04"><a href="<?php echo HTTP.'/akihabara/plan';?>">RESERVATION<span><?php echo __('lbl_reservation');?></span></a></li>
<?php else: ?>
<li class="nav04"><a href="<?php echo HTTP.'/akihabara/mypage';?>">MYPAGE<span><?php echo __('lbl_mypage');?></span></a></li>
<?php endif; ?>
<!-- <li class="nav05"><a href="https://ssl.rwiths.net/r-withs/rfcReserveConfirmLogin.do?hotelNo=151187" target="_blank">予約の確認とキャンセル<br>Reservation Confirm &amp; Cancel</a></li> -->
<li class="nav06"><a href="https://grids-hostel.com/sp/<?php echo Helper_Common::grids_lang(__('use_lang'), false); ?>.html">CONCEPT</a></li>
<li class="nav07"><a href="https://grids-hostel.com/hostels/nihonbashi-east/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>">NIHOMBASHI-EAST</a></li>
<li class="nav08"><?php echo "<a href='".HTTP."/akihabara/language/ja'>"; ?>JP</a>／<?php echo "<a href='".HTTP."/akihabara/language/en'>"; ?>EN</a>
／<a href="<?php echo HTTP."/akihabara/language/ko" ?>">한국어</a>／<a href="<?php echo HTTP."/akihabara/language/tw" ?>">中文（繁体）</a>／<a href="<?php echo HTTP."/akihabara/language/ch" ?>">中文（簡体）</a>
</li>
</ul>

</div>
</header>
<!-- /header -->

<!-- contents -->
<?php echo $content; ?>
<!-- /contents -->

<!-- footer -->
<footer>
<div class="inner">
<ul class="ftLink">
<li class="leftLink"><a href="https://grids-hostel.com/hostels/akihabara/<?php echo Helper_Common::grids_lang(__('use_lang')); ?>"><?php echo __('lbl_akihabara');?></a></li>
<!-- <li class="rightLink"><a href="#"><?php echo __('lbl_cancelpolicy');?></a></li> -->
</ul>
</div>
</footer>
<!-- /footer -->

</div>
<!-- wrapper -->

</body>
</html>
