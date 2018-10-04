<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{if ($user_id != 'passwordreminder' && !isset($flg))}--><--{__('lbl_signup')}--><--{else}--><--{__('lbl_password_again2')}--><--{/if}--></h2>
<h4 style="color: red;">
<--{$error}-->
</h4>
<div class="loginBox clearfix">
<div class="inputBox">
<h3><--{__('lbl_ikawonyuryoku')}--></h3>

<--{Form::open($action)}-->
<div class="inputForm">
<--{if ($user_id == 'passwordreminder')}-->
<dl>
<dt><--{__('lbl_mailaddress')}--></dt>
<dd><input type="text" name="mailAddress" id=""></dd>
</dl>
<--{/if}-->

<--{if ($user_id != 'passwordreminder')}-->
<dl>
<dt><--{__('lbl_password')}--></dt>
<dd><input type="password" name="loginPass" id=""></dd>
</dl>
<dl>
<dt><--{__('lbl_password_again')}--></dt>
<dd><input type="password" name="loginPass2" id=""></dd>
</dl>
<dl>

<--{if (!isset($flg))}-->
<dt><--{__('lbl_mailmagazine')}--></dt>
</dl>
<dl>
<input type="radio" name="mail" id="privilege01" value="1" ><dt><label for="privilege01"><--{__('lbl_want')}--></label></dt>
<input type="radio" name="mail" id="privilege02" value="2" ><dt><label for="privilege02"><--{__('lbl_not_want')}--></label></dt>
</dl>
<--{/if}-->

<input type="hidden" name="id" value="<--{$user_id}-->">
<input type="hidden" name="token" value="<--{$token}-->">
<input type="hidden" name="<--{Config::get('security.csrf_token_key')}-->" value="<--{Security::fetch_token()}-->">
<input type="hidden" name="type" value="<--{$type}-->">
<--{/if}-->
</div>
<p class="btn"><input type="submit" value="<--{__('lbl_submit')}-->"></p>
<--{Form::close()}-->
</div>


</div>
</section>
</div>

</div>