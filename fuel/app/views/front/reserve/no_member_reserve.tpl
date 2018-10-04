<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{__('lbl_reserve')}--></h2>
<p style="color:red;"><--{$error}--></p>
<div class="reserveBox">
<ol class="formStep clearfix">
<li class="current"><span><--{__('lbl_reserve_info')}-->・<br><--{__('lbl_adjust_input')}--></span></li>
<li><span><--{__('lbl_input_info')}--><br><--{__('lbl_check')}--></span></li>
<li><span><--{__('lbl_reserve2')}--><br><--{__('lbl_done')}--></span></li>
</ol>
<div class="lead">
<p><span class="required"><--{__('lbl_required')}--></span><--{__('lbl_rule')}--></p>
</div>
<div class="inputBox">
<--{Form::open($action)}-->
<dl>
<dt><span><--{__('lbl_reserve_info2')}--></span></dt>
<dd>
<table>
<tr>
<th><span><--{__('lbl_htl')}--></span></th>
<td><em class="blue"><--{$htl_name}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_room_type2')}--></span></th>
<td><em><--{$plan.TYPE_NAME}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_arrive_date2')}--></span></th>
<td><em><--{$plan.DATE}--></em></td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_arrive_time2')}--></span></th>
<td>
<select name="ciTime" id="ciTime01">
<--{foreach from=$plan.CHECK_IN item=item}-->
<option value="<--{$item}-->"><--{$item}--></option>
<--{/foreach}-->
</select>
<p class="note">※<--{__('lbl_okurerubaai')}--><br><--{__('lbl_rennrakudekinai')}--></p>
</td>
</tr>
<tr>
<th><span class="required"></span><span><--{__('lbl_staynum')}--></span></th>
<td><--{$plan.STAYDATENUM|number_format}--><--{__('lbl_stay')}--></td>
</tr>
<!-- <tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_staynum')}--></span></th>
<td><select name="stayCount" id="stayCount01">
<option value="1">1</option>
</select>
<--{__('lbl_stay')}--></td>
</tr> -->
<tr>
<th><span class="required"></span><span><--{__('lbl_room_num')}--></span></th>
<td><--{$plan.STAYROOMNUM|number_format}--><--{__('lbl_room')}--></td>
</tr>
<!-- <tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_room_num')}--></span></th>
<td><select name="stayRoom" id="stayRoom01">
<option value="1">1</option>
</select>
部屋<--{__('')}--></td>
</tr> -->
<tr>
<th><span><--{__('lbl_payment')}--></span></th>
<td><em><--{($price_total)|number_format}--><--{__('lbl_yen')}--></em></td>
</tr>
</table>
</dd>
</dl>
<dl>
<dt><span><--{__('lbl_account_info')}--></span></dt>
<dd>
<table<--{if (__('use_lang') != 'ja')}--> style="border-top:1px solid #ccc;"<--{/if}-->>
<tr<--{if (__('use_lang') != 'ja')}--> style="display:none;"<--{/if}-->>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_name')}--></span></th>
<td><--{__('lbl_name_sei')}--><input type="text" name="name" id="name01" class="length01" value="<--{if (isset($form.name))}--><--{$form.name}--><--{/if}-->" ><--{__('lbl_name_mei')}--><input type="text" name="name2" id="name02" class="length01" value="<--{if (isset($form.name2))}--><--{$form.name2}--><--{/if}-->"></td>
</tr>
<!-- <tr>
<th><span class="required"><--{__('lbl_required')}--></span><span>氏名</span></th>
<td><input type="text" name="name2" id="name02" class="length01" value="<--{if (isset($form.name2))}--><--{$form.name2}--><--{/if}-->"></td>
</tr> -->
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_name_kana')}--></span></th>
<td><--{__('lbl_kana_sei')}--><input type="text" name="kana" id="kana" class="length01" value="<--{if (isset($form.kana))}--><--{$form.kana}--><--{/if}-->"><--{__('lbl_kana_mei')}--><input type="text" name="kana2" id="kana" class="length01" value="<--{if (isset($form.kana2))}--><--{$form.kana2}--><--{/if}-->"></td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_gender')}--></span></th>
<td>
<input type="radio" name="gender" id="gender01" <--{$man_flg}--> value="1" ><label for="gender01"><--{__('lbl_man')}--></label>
<input type="radio" name="gender" id="gender02" <--{$woman_flg}--> value="2" ><label for="gender02"><--{__('lbl_woman')}--></label>
</td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_user_tel')}--></span></th>
<td><input type="tel" name="tel" id="tel01" class="length01" value="<--{if (isset($form.tel))}--><--{$form.tel}--><--{/if}-->"></td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span>E-mail</span></th>
<td><input type="email" name="email" id="email01" class="length04" value="<--{if (isset($form.email))}--><--{$form.email}--><--{/if}-->"></td>
</tr>
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span>E-mail<--{__('lbl_input_again')}--></span></th>
<td><input type="email" name="email_re" id="email01_re" class="length04" value="<--{if (isset($form.email_re))}--><--{$form.email_re}--><--{/if}-->"></td>
</tr>
<tr>
<th><span><--{__('lbl_birthday')}--></span></th>
<td><input type="text" name="ciDate" id="ciDateYMD" value="<--{if (isset($form.ciDate))}--><--{$form.ciDate}--><--{/if}-->" class="length03"><label for="ciDateYMD"></label></td>
</tr>
<!-- <tr>
<th><span>E-mail(登録2)</span></th>
<td><input type="email" name="email2" id="email02" class="length04" value="<--{if (isset($form.email2))}--><--{$form.email2}--><--{/if}-->"></td>
</tr>
<tr>
<th><span>E-mail(登録3)</span></th>
<td><input type="email" name="email3" id="email03" class="length04" value="<--{if (isset($form.email3))}--><--{$form.email3}--><--{/if}-->" ></td>
</tr> -->

<tr>
<th><span><--{__('lbl_fax_num')}--></span></th>
<td><input type="tel" name="fax" id="fax01" class="length01" value="<--{if (isset($form.fax))}--><--{$form.fax}--><--{/if}-->" ></td>
</tr>
<tr>
<th><span><--{__('lbl_address')}--></span></th>
<td>
<p><span><--{__('lbl_zipcode')}--></span><input type="tel" name="zipcode" id="zipcode01" class="length01" value="<--{if (isset($form.zipcode))}--><--{$form.zipcode}--><--{/if}-->"></p>
<p><span><--{__('lbl_address2')}--></span><input type="text" name="address1" id="address01" class="length04" value="<--{if (isset($form.address1))}--><--{$form.address1}--><--{/if}-->"></p>
<p><span><--{__('lbl_address3')}--></span><input type="text" name="address2" id="address02" class="length04" value="<--{if (isset($form.address2))}--><--{$form.address2}--><--{/if}-->"></p>
</td>
</tr>
<tr class="payment">
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_adjust')}--></span></th>
<td>
<input type="radio" name="paymentFlg" id="paymentFlg01" value="1" <--{if ($htl_type == '1')}-->checked<--{/if}--> ><label for="paymentFlg01"><--{__('lbl_local')}--></label>
<--{if ($htl_type == '0')}-->
<!-- <input type="radio" name="paymentFlg" id="paymentFlg02" value="2"><label for="paymentFlg02"><--{__('lbl_online')}--></label> -->
<--{/if}-->
</td>
</tr>
</table>
</dd>
</dl>
<dl>
<dt><span><--{__('lbl_about_regist')}--></span></dt>
<dd>
<table>
<tr class="register">
<!-- <th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_regist_msg')}--></span></th> -->
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_signup')}--></span></th>
<td>
<input type="radio" name="register" id="register01" value="1" checked="checked"><label for="register01"><--{__('lbl_do')}--></label>
<!-- <input type="radio" name="register" id="register01" value="1"><label for="register01">する</label> -->
<!-- <input type="radio" name="register" id="register02" value="2"><label for="register02">しない</label> -->
</td>
</tr>
</table>
</dd>
</dl>
<div class="policyTxt">
<p><--{__('lbl_ssl')}--></p>
<p class="check"><input type="checkbox" name="policy" id="policy01"><label for="policy01"><--{__('lbl_agree')}--></label></p>
</div>
<ul class="btn">
<li><input type="submit" value="<--{__('lbl_to_reserve_confirm')}-->"></li>
</ul>
<--{Form::close()}-->
</div>
</div>
<div class="reserveNote">
<p><--{__('lbl_message1')}--><br><--{__('lbl_message2')}--></p>
<--{if (__('use_lang') == 'ja')}-->
<p><--{__('lbl_message3')}--><a href="https://grids-hostel.com/privacy/" target="_blank"><--{__('lbl_policy')}--></a><--{__('lbl_message4')}--><br><--{__('lbl_message5')}--></p>
<--{else}-->
<p><--{__('lbl_message3')}--><a href="https://grids-hostel.com/privacy/index_en.html" target="_blank"><--{__('lbl_policy')}--></a><--{__('lbl_message4')}--><br><--{__('lbl_message5')}--></p>
<--{/if}-->
</div>
</section>
</div>

</div>
