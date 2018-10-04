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
<th><span><--{__('lbl_staynum')}--></span></th>
<!-- <td><select name="stayCount" id="stayCount01">
<option value="1">1</option>
</select>
泊</td> -->
<td><em><--{$plan.STAYDATENUM|number_format}--><--{__('lbl_stay')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_room_num')}--></span></th>
<!-- <td><select name="stayRoom" id="stayRoom01">
<option value="1">1</option>
</select>
部屋</td> -->
<td><em><--{$plan.STAYROOMNUM|number_format}--><--{__('lbl_room2')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_payment')}--></span></th>
<td><em><--{($price_total)|number_format}--><--{__('lbl_yen')}--></em></td>
</tr>
</table>
</dd>
</dl>
<dl>
<dt><span><--{__('lbl_account_info')}--></span><span class="btn"><a href="<--{$mypage_edit_url}-->"><--{__('lbl_edit_account2')}--></a></span></dt>
<dd>
<table>
<tr>
<th><span><--{__('lbl_user_no')}--></span></th>
<td><--{$user.USR_ID}--></td>
</tr>
<tr<--{if (__('user_lang') != 'ja')}--> style="display:none;"<--{/if}-->>
<th><span><--{__('lbl_name')}--><--{__('lbl_name_sei')}--></span></th>
<td><--{$user.USR_SEI}--></td>
</tr>
<tr<--{if (__('user_lang') != 'ja')}--> style="display:none;"<--{/if}-->>
<th><span><--{__('lbl_name')}--><--{__('lbl_name_mei')}--></span></th>
<td><--{$user.USR_MEI}--></td>
</tr>
<tr>
<th><span><--{__('lbl_name_kana')}--></span></th>
<td><--{$user.USR_KANA}--></td>
</tr>
<tr>
<th><span>E-mail</span></th>
<td><--{$user.USR_MAIL}--></td>
</tr>
</table>
</dd>
<dd>
<table>
<tr class="payment">
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_adjust')}--></span></th>
<td>
<input type="radio" name="paymentFlg" id="paymentFlg01" value="1" <--{if ($htl_type == '1')}-->checked<--{/if}--> ><label for="paymentFlg01"><--{__('lbl_local')}--></label>
<--{if ($htl_type == '0')}-->
<input type="radio" name="paymentFlg" id="paymentFlg02" value="2"><label for="paymentFlg02"><--{__('lbl_online')}--></label>
<--{/if}-->
</td>
</tr>
<--{if ($discount_flg == 1)}-->
<tr>
<th><span class="required"><--{__('lbl_required')}--></span><span><--{__('lbl_discount_benefits')}--></span></th>
<td>
<input type="radio" name="privilege" id="privilege01" value="1" checked><label for="privilege01"><--{__('lbl_not_use')}--></label>

<input type="radio" name="privilege" id="privilege02" value="2"><label for="privilege02"><--{__('lbl_use')}-->（<--{__('lbl_yen_mark')}--><--{DISCOUNT|number_format}--><--{__('lbl_discount')}-->）</label>
<!-- <input type="radio" name="privilege" id="privilege02" value="1" disabled><label for="privilege02">利用できません</label> -->
</td>
</tr>
<--{else}-->
<--{/if}-->

</table>
</dd>
</dl>
<div class="policyTxt">
<p><--{__('lbl_ssl')}--></p>
<p class="check"><input type="checkbox" name="policy" id="policy01"><label for="policy01"><--{__('lbl_agree')}--></label></p>
</div>
<ul class="btn">

<input type="hidden" name="<--{Config::get('security.crsf_token_key')}-->">
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
