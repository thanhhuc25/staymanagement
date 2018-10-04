<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{__('lbl_reserve')}--></h2>
<div class="reserveBox">
<ol class="formStep clearfix">
<li><span><--{__('lbl_reserve_info')}-->・<br><--{__('lbl_adjust_input')}--></span></li>
<li class="current"><span><--{__('lbl_input_info')}--><br><--{__('lbl_check')}--></span></li>
<li><span><--{__('lbl_reserve2')}--><br><--{__('lbl_done')}--></span></li>
</ol>
<div class="lead">
<p><--{__('lbl_confirm_msg')}--></p>
</div>
<div class="inputBox">
<--{Form::open($action)}-->
<dl>
<dt><span><--{__('lbl_reserve')}--></span></dt>
<dd>
<table<--{if (__('use_lang') != 'ja')}--> style="border-top:1px solid #ccc;"<--{/if}-->>
<tr<--{if (__('use_lang') != 'ja')}--> style="display:none;"<--{/if}-->>
<th><span><--{__('lbl_user_name')}--></span></th>
<td><em><--{$user.USR_KANA}--> <--{__('lbl_sama')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_arrive_date2')}--></span></th>
<td><em><--{$plan.DATE}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_arrive_time2')}--></span></th>
<td><em><--{$plan.CHECK_IN}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_leave_date2')}--></span></th>
<td><em><--{$plan.DATE2}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_room_type2')}--></span></th>
<td><em><--{$rtype.TYPE_NAME}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_person_num')}--></span></th>
<td><em><--{$person_total_num}--><--{__('lbl_person')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_staynum')}--></span></th>
<td><em><--{$param.stay_count}--><--{__('lbl_stay')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_room_num')}--></span></th>
<td><em><--{$param.room_num}--><--{__('lbl_room2')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_payment')}--></span></th>
<td><em><--{($price_total)|number_format}--><--{__('lbl_yen')}--></em></td>
</tr>
<tr>
<th><span><--{__('lbl_user_name_kana')}--></span></th>
<td><em><--{$user.USR_KANA}--></em></td>
</tr>
<tr>
<th><span>E-mail</span></th>
<td><em><--{$user.USR_MAIL}--></em></td>
</tr>
</table>
</dd>
</dl>
<div class="reserveSpec">
<dl>
<dt><span><--{__('lbl_payment_list')}--></span><span class="note"><--{__('lbl_include_tax_service')}--></span></dt>
<dd class="spec">
<table>
<tr>
<th class="spHide"><--{__('lbl_satydate')}--></th>
<th class="spHide"><--{__('lbl_cost')}--></th>
<th class="spHide"><--{__('lbl_plan_name')}--></th>
<th class="spHide"><--{__('lbl_payment_a_room')}--></th>
</tr>
<--{foreach from=$price key=k item=item}-->
<tr>
<td><span class="pcHide"><--{__('lbl_satydate')}--></span><--{$k}--></td>
<td><span class="pcHide"><--{__('lbl_cost')}--></span><--{$item.one_person|number_format}--><--{__('lbl_yen')}-->　×　<--{$param.person_num}--><--{__('lbl_person_num2')}--></td>
<td><span class="pcHide"><--{__('lbl_plan_name')}--></span><--{$plan.PLN_NAME}--></td>
<td><span class="pcHide"><--{__('lbl_payment_a_room')}--></span><--{$item.one_stay|number_format}--><--{__('lbl_yen')}--></td>
</tr>
<--{/foreach}-->
</table>
</dd>
<dd class="total">
<table>
<tr>
<th><--{__('lbl_total')}--></th>
<--{if ($discount_flg == 0)}-->
<td><--{$price_sum|number_format}--><--{__('lbl_yen')}-->　×　<--{$param.room_num}--><--{__('lbl_room')}-->　=　<--{$price_total|number_format}--><--{__('lbl_yen')}--></td>
<--{else}-->
<td><--{$price_sum|number_format}--><--{__('lbl_yen')}-->　×　<--{$param.room_num}--><--{__('lbl_room')}-->　- <--{DISCOUNT|number_format}--><--{__('lbl_yen')}-->  = <--{$price_total|number_format}--><--{__('lbl_yen')}--></td>
<--{/if}-->
</tr>
</table>
<p class="note"><--{__('lbl_include_tax_service2')}--></p>
</dd>
</dl>
</div>
<div class="policyTxt">
<p><--{__('lbl_confirm2')}--></p>
</div>
<ul class="btn">
<li><input type="submit" value="<--{__('lbl_reserve_button')}-->"></li>
<li class="back"><input type="button"  value="<--{__('lbl_back')}-->" onClick="history.go(-1);"></li>
</ul>
<--{Form::close()}-->
</div>
</div>
<div class="policyTable">
<table>
<tr>
<th><--{__('lbl_cancelpolicy')}--></th>
<td>
<p>
<--{'○月○日'|str_replace:$plan.DATE3:__('lbl_cancel_pay')}--></p>
</td>
</tr>
<tr>
<th><--{__('lbl_warning')}--></th>
<td>
<p class="attention"><--{__('lbl_warning_msg1')}--></p>
<p class="attention indent"><--{__('')}--></p>
</td>
</tr>
</table>
</div>
</section>
</div>

</div>
