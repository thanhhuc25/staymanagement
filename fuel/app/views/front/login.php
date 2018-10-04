<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<?php echo FRONT_INC_LOGIN_MENU_HTML;?>
</div>
<section>
<h2><?php echo __('lbl_rsvlogin');?></h2>
<h4 style="color: red;">
<?php echo $error;?>
</h4>
<div class="loginBox clearfix">
<div class="inputBox">
<h3><?php echo __('lbl_member');?></h3>
<?php echo Form::open($action); ?>
<div class="inputForm">
<dl>
<dt><?php echo __('lbl_mailaddress');?></dt>
<dd><input type="email" name="loginMail" id="loginMail01"></dd>
</dl>
<dl>
<dt><?php echo __('lbl_password');?></dt>
<dd><input type="password" name="loginPass" id="loginPass01"></dd>
</dl>
<p class="note"><?php echo __('lbl_forgot_pass');?><a href="<?php echo $passreminder; ?>"><?php echo __('lbl_here');?></a>。</p>
</div>
<p class="btn"><input type="submit" value="<?php echo __('lbl_login');?>"></p>
<?php echo Form::close();?>
</div>
<div class="inputBox">
<!-- <h3 class="col2">非会員の方で<br>予約確認・変更・取消される方</h3> -->
<h3 class="col2"><?php echo __('lbl_no_member');?></h3>
<?php echo Form::open($action2); ?>
<div class="inputForm" style="height: 105px">
<dl>
<!-- <dt>メールアドレス</dt> -->
<!-- <dd><input type="email" name="loginMail" id="loginMail02"></dd> -->
</dl>
<dl>
<!-- <dt>ご予約NO.</dt> -->
<!-- <dd><input type="tel" name="reserveNum" id="reserveNum01"></dd> -->
</dl>
</div>
<!-- <p class="btn"><input type="submit" value="送　信"></p> -->
<p class="btn" style="position: relative; top: -80px;"><input type="submit" value="<?php echo __('lbl_signup');?>"></p>
<?php echo Form::close();?>
</div>
</div>
</section>
</div>

</div>