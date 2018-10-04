<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ログイン | STAY MANAGER</title>
<meta name="description" content="">
<meta name="keywords" content="" >
<meta name="format-detection" content="telephone=no">
<?php echo Asset::css("reset.css"); ?>
<?php echo Asset::css("style.css"); ?>
<!-- <link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/style.css"> -->
<?php echo Asset::js("jquery-2.2.0.min.js"); ?>
<?php echo Asset::js("common.js"); ?>
<!-- <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="js/common.js"></script> -->
</head>
<body class="login">
<div id="wrapper">
<!-- header -->
<header></header>
<!-- /header -->
<!-- contents -->
<div id="contents">
<div class="inner">
<!-- <h1 class="logo"><img src="img/logo01.png" alt="STAY MANAGER"></h1> -->
<h1 class="logo"><?php echo Asset::img('logo01.png',array('alt' => 'STAY MANAGER')) ?></h1>
<div class="loginBox">
<!-- <form action="" method="post"> -->
<?php echo Form::open(array('action' => 'admin/index/login', 'method' => 'post')); ?>
<table>
<tr>
<th>ID</th>
<td><input type="txt" name="loginId" id="loginId"></td>
</tr>
<tr>
<th>パスワード</th>
<td><input type="password" name="loginPass" id="loginPass"></td>
</tr>
</table>
<p class="loginBtn"><input type="submit" value="ログイン"></p>
<?php echo Form::close(); ?>
<!-- </form> -->
</div>
</div>
</div>
<!-- /contents -->
<!-- footer -->
<footer></footer>
<!-- /footer -->
</div>
<!-- wrapper -->
</body>
</html>