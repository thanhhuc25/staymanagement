<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{__('lbl_login')}--></h2>
<--{if ($htl_id == 1)}-->
<--{if (__('use_lang') == 'ja')}-->
<p style="text-align:center;margin:3% 0 0;">9月19日以前にご予約したお客様のご予約の確認、変更、キャンセルは<a href="https://ssl.rwiths.net/r-withs/rfcReserveConfirmLogin.do?hotelNo=147902" target="_blank">こちら</a></p>
<--{else}-->
<p style="text-align:center;margin:3% 0 0;"><a href="https://ssl.rwiths.net/r-withs/rfcReserveConfirmLogin.do?hotelNo=147902" target="_blank"><--{__('lbl_before_919')}--></a></p>
<--{/if}-->
<--{elseif ($htl_id == 2)}-->
<--{if (__('use_lang') == 'ja')}-->
<p style="text-align:center;margin:3%;">9月19日以前にご予約したお客様のご予約の確認、変更、キャンセルは<a href="https://ssl.rwiths.net/r-withs/rfcReserveConfirmLogin.do?hotelNo=151187" target="_blank">こちら</a></p>
<--{else}-->
<p style="text-align:center;margin:3%;"><a href="https://ssl.rwiths.net/r-withs/rfcReserveConfirmLogin.do?hotelNo=151187" target="_blank"><--{__('lbl_before_919')}--></a></p>
<--{/if}-->
<--{/if}-->
<h4 style="color: red;">
<--{$error}-->
</h4>
<div class="loginBox clearfix">
<div class="inputBox">
<h3><--{__('lbl_member')}--></h3>
<--{Form::open($action)}-->
<div class="inputForm">
<dl>
<dt><--{__('lbl_mailaddress')}--></dt>
<dd><input type="email" name="loginMail" id="loginMail01"></dd>
</dl>
<dl>
<dt><--{__('lbl_password')}--></dt>
<dd><input type="password" name="loginPass" id="loginPass01"></dd>
</dl>
<p class="note"><--{__('lbl_forgot_pass')}--><a href="<--{$passreminder}-->"><--{__('lbl_here')}--></a></p>
</div>
<p class="btn"><input type="submit" value="<--{__('lbl_login')}-->"></p>
<--{Form::close()}-->
</div>
<div class="inputBox">
<!-- <h3 class="col2">非会員の方で<br>予約確認・変更・取消される方</h3> -->
<h3 class="col2"><--{__('lbl_no_member')}--></h3>
<--{Form::open($nm_action)}-->
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
<p class="btn" style="position: relative; top: -80px;"><input type="submit" value="<--{__('lbl_signup')}-->"></p>
<--{Form::close()}-->
</div>
</div>

</section>
</div>

</div>
