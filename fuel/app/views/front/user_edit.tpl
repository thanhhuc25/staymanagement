<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{__('lbl_edit_account')}--></h2>

<div class="reserveBox">
<div class="lead">
<p><span class="required"><--{__('lbl_required')}--></span><--{__('lbl_musut_input')}--></p>
<p style="color: red;"><--{$error}--></p>
</div>
<div class="inputBox">
<--{Form::open($action)}-->
<dl>
<dt><span><--{__('lbl_account_info')}--></span></dt>
<dd>
<table<--{if (__('use_lang') != 'ja')}--> style="border-top:1px solid #ccc;"<--{/if}-->>
<tr<--{if (__('use_lang') != 'ja')}--> style="display:none;"<--{/if}-->>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_name')}--></span></th>
<td><--{__('lbl_name_sei')}--><input type="text" name="USR_SEI" id="name01" class="length01" value="<--{if (isset($form.USR_SEI))}--><--{$form.USR_SEI}--><--{else}--><--{$USR_SEI}--><--{/if}-->"><--{__('lbl_name_mei')}--><input type="text" name="USR_MEI" id="name02" class="length01" value="<--{if (isset($form.USR_MEI))}--><--{$form.USR_MEI}--><--{else}--><--{$USR_MEI}--><--{/if}-->"></td>
</tr>
<!-- <tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_name')}--></span></th>
<td><input type="text" name="USR_MEI" id="name02" class="length01" value="<--{if (isset($form.USR_MEI))}--><--{$form.USR_MEI}--><--{else}--><--{$USR_MEI}--><--{/if}-->"></td>
</tr> -->
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_name_kana')}--></span></th>
<td><--{__('lbl_kana_sei')}--><input type="text" name="KANA_SEI" id="kana" class="length01" value="<--{if (isset($form.KANA_SEI))}--><--{$form.KANA_SEI}--><--{else}--><--{$KANA_SEI}--><--{/if}-->"><--{__('lbl_kana_mei')}--><input type="text" name="KANA_MEI" id="kana" class="length01" value="<--{if (isset($form.KANA_MEI))}--><--{$form.KANA_MEI}--><--{else}--><--{$KANA_MEI}--><--{/if}-->"></td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_gender')}--></span></th>
<td>
<input type="radio" name="gender" id="gender01" value="1" <--{$gender_flg1}--> ><label for="gender01"><--{__('lbl_man')}--></label>
<input type="radio" name="gender" id="gender02" value="2" <--{$gender_flg2}--> ><label for="gender02"><--{__('lbl_woman')}--></label>
</td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_user_tel')}--></span></th>
<td><input type="tel" name="USR_TEL" id="tel01" class="length01" value="<--{if (isset($form.USR_TEL))}--><--{$form.USR_TEL}--><--{else}--><--{$USR_TEL}--><--{/if}-->" ></td>
</tr>

<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span>E-mail</span></th>
<td><input type="email" name="USR_MAIL" id="email01" class="length04" value="<--{if (isset($form.USR_MAIL))}--><--{$form.USR_MAIL}--><--{else}--><--{$USR_MAIL}--><--{/if}-->" ></td>
</tr>

<tr>
<th><span><--{__('lbl_birthday')}--></span></th>
<td><input type="text" name="USR_BIRTH" id="ciDateYMD" value="<--{if (isset($form.USR_BIRTH))}--><--{$form.USR_BIRTH}--><--{else}--><--{$USR_BIRTH}--><--{/if}-->" class="length03"><label for="ciDateYMD"></label></td>
</tr>
<tr>
<th><span><--{__('lbl_fax_num')}--></span></th>
<td><input type="tel" name="USR_FAX" id="fax01" class="length01" value="<--{if (isset($form.USR_FAX))}--><--{$form.USR_FAX}--><--{else}--><--{$USR_FAX}--><--{/if}-->" ></td>
</tr>
<tr>
<th><span><--{__('lbl_address')}--></span></th>
<td>
<p><span><--{__('lbl_zipcode')}--></span><input type="tel" name="ZIP_CD" id="zipcode01" class="length01" value="<--{$ZIP_CD}-->"></p>
<p><span><--{__('lbl_address2')}--></span><input type="text" name="USR_ADR1" id="address01" class="length04" value="<--{if (isset($form.USR_ADR1))}--><--{$form.USR_ADR1}--><--{else}--><--{$USR_ADR1}--><--{/if}-->"></p>
<p><span><--{__('lbl_address3')}--></span><input type="text" name="USR_ADR2" id="address02" class="length04" value="<--{if (isset($form.USR_ADR2))}--><--{$form.USR_ADR2}--><--{else}--><--{$USR_ADR2}--><--{/if}-->"></p>
</td>
</tr>
</table>
</dd>
</dl>

<dl>
<dt><span><--{__('lbl_account_setting')}--></span></dt>
<dd>
<table>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_mailmagazine')}--></span></th>
<td>
<input type="radio" name="magazine" id="magazine1" value="1" <--{$magazine_flg1}--> ><label for="magazine1"><--{__('lbl_do_deliver')}--></label>
<input type="radio" name="magazine" id="magazine2" value="2" <--{$magazine_flg2}--> ><label for="magazine2"><--{__('lbl_do_not_deliver')}--></label>
</td>
</tr>
<tr>
<th><span><--{__('lbl_password_change')}--></span></th>
<td>
<input type="radio" name="changepasswd" id="chgpass01" value="1"><label for="chgpass01"><--{__('lbl_do')}--></label>
<input type="radio" name="changepasswd" id="chgpass02" value="2" checked="checked"><label for="chgpass02"><--{__('lbl_not_do')}--></label>
</td>
</tr>
<tr class="chgpass" style="display: none;">
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_password')}--></span></th>
<td><input type="password" name="password" class="length04"></td>
</tr>
<tr class="chgpass" style="display: none;">
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_password_again')}--></span></th>
<td><input type="password" name="password_re" class="length04"></td>
</tr>
</table>
</dd>
</dl>
<input type="hidden" name="action" value="<--{$back_url}-->" >
<ul class="btn">
<li><input type="submit" value="<--{__('lbl_save')}-->"></li>
</ul>
</form>
</div>
</div>
</section>
</div>
</div>