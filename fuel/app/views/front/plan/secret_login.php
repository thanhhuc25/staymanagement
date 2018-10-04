<!-- contents -->
<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<?php echo FRONT_INC_LOGIN_MENU_HTML;?>
</div>
<section>
<h2 style="padding-right:18px;"><?php echo $secret['PLN_TYPE']; ?> ログインページ</h2>

<div class="loginBox">
<div class="inputBox" style="float:none;margin:0 auto;">
<h3>会員の方</h3>
<form action="" accept-charset="utf-8" method="post">
<div class="inputForm">
<dl>
<dt>パスワード</dt>
<dd><input type="password" name="password" id="password"></dd>
</dl>
<?php if ($message): ?>
<p style="color:orangered;"><?php echo $message; ?></p>
<?php endif; ?>
</div>
<p class="btn"><input type="submit" value="ログイン"></p>
</form>
</div>

</div>
</section>
</div>

</div>
<!-- /contents -->
