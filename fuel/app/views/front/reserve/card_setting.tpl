<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{if (isset($reserved_flg) && $reserved_flg == '1')}--><--{__('lbl_input_card_info')}--><--{else}--><--{__('lbl_reserve')}--><--{/if}--></h2>
<p style="color: red;"><--{$error}--></p>
<div class="reserveBox">
<--{if (!isset($reserved_flg) || $reserved_flg != '1')}-->
<ol class="formStep clearfix">
<li class="current"><span><--{__('lbl_reserve_info')}-->・<br><--{__('lbl_adjust_input')}--></span></li>
<li><span><--{__('lbl_input_info')}--><br><--{__('lbl_check')}--></span></li>
<li><span><--{__('lbl_reserve2')}--><br><--{__('lbl_done')}--></span></li>
</ol>
<--{/if}-->
<div class="lead">
<p><--{__('lbl_rule2')}--></p>
</div>
<div class="inputBox">
<!-- <form action="" method="post"> -->
<--{Form::open($action)}-->
<dl>
<dt><span><--{__('lbl_use_info')}--></span></dt>
<dd>
<table>
<tr>
<th><--{__('lbl_payment2')}--></th>
<td><--{__('lbl_yen_mark')}--><--{$price_total|number_format}-->−</td>
</tr>
<tr>
<th><--{__('lbl_billing_for_payment')}--></th>
<td><--{$claim_name}--> <--{__('lbl_sama')}--></td>
</tr>
</table>
</dd>
</dl>
<dl>
<--{if ($list_flg == '1')}-->
<dt><span><--{__('lbl_select_card')}--></span></dt>
<dd class="paymentSelect">
<table>
<tr>
<td colspan="3"><span><input type="radio" name="cardType" id="cardType01" value="1" ><label for="cardType01"><--{__('lbl_existing_card')}--></label></span></td>
</tr>
<tr>
<th><--{__('lbl_card_company')}--></th>
<th class="spHide"><--{__('lbl_card_no')}-->　/　<--{__('lbl_card_account_name')}--></th>
<th class="spHide"><--{__('lbl_effective_date')}--></th>
</tr>
<--{foreach from=$card_list key=key item=item}-->
<tr class="cardSelect">
<td><input type="radio" name="cardCom" id="cardCom<--{$key}-->" value="<--{$key}-->"><label for="cardCom<--{$key}-->"><--{$item.comp_name}--></label></td>
<td>****-****-****-<--{$item.card_no}-->　/　<--{$item.owner_name}--></td>
<td><--{$item.month}--><--{__('lbl_month')}-->　/　<--{$item.year}--><--{__('lbl_year')}--></td>
</tr>
<--{/foreach}-->
</table>
</dd>
<--{/if}-->
<dd class="paymentSelect">
<table>
<tr>
<td colspan="2"><span><input type="radio" name="cardType" id="cardType02" value="2" <--{if (isset($new_card) || $list_flg == '0')}-->checked<--{/if}--> ><label for="cardType02"><--{__('lbl_card_alert2')}--></label></span><span class="img"><--{Asset::img('front/img_card_pay_01.png',  ["alt" => ""] )}--></span></td>
</tr>
<tr>
<th><--{__('lbl_card_account_name2')}--></th>
<td><input type="text" name="cardName" id="cardName01" class="length05" value="<--{if (isset($new_card.name))}--><--{$new_card.name}--><--{/if}-->"><p class="note"><--{__('lbl_card_sample2')}--></p></td>
</tr>
<tr>
<th><--{__('lbl_card_no')}--></th>
<td><input type="tel" name="cardNum" id="cardNum01" class="length05" value="<--{if (isset($new_card.no))}--><--{$new_card.no}--><--{/if}-->" ><p class="note"><--{__('lbl_card_sample1')}--></p></td>
</tr>
<tr>
<th><--{__('lbl_security_code')}--></th>
<td><input type="tel" name="cardCord" id="cardCord01" class="length06" maxlength="4" value="<--{if (isset($new_card.sc))}--><--{$new_card.sc}--><--{/if}-->"><p class="note"><--{__('lbl_card_alert1')}--></p></td>
</tr>
<tr>
<th><--{__('lbl_card_effective_date')}--></th>
<td><select name="cardDate_m" id="cardDate01">
<option value="1"  <--{if (isset($new_card.month) && $new_card.month == '1' )}-->selected<--{/if}--> >01</option>
<option value="2"  <--{if (isset($new_card.month) && $new_card.month == '2' )}-->selected<--{/if}--> >02</option>
<option value="3"  <--{if (isset($new_card.month) && $new_card.month == '3' )}-->selected<--{/if}--> >03</option>
<option value="4"  <--{if (isset($new_card.month) && $new_card.month == '4' )}-->selected<--{/if}--> >04</option>
<option value="5"  <--{if (isset($new_card.month) && $new_card.month == '5' )}-->selected<--{/if}--> >05</option>
<option value="6"  <--{if (isset($new_card.month) && $new_card.month == '6' )}-->selected<--{/if}--> >06</option>
<option value="7"  <--{if (isset($new_card.month) && $new_card.month == '7' )}-->selected<--{/if}--> >07</option>
<option value="8"  <--{if (isset($new_card.month) && $new_card.month == '8' )}-->selected<--{/if}--> >08</option>
<option value="9"  <--{if (isset($new_card.month) && $new_card.month == '9' )}-->selected<--{/if}--> >09</option>
<option value="10" <--{if (isset($new_card.month) && $new_card.month == '10')}-->selected<--{/if}--> >10</option>
<option value="11" <--{if (isset($new_card.month) && $new_card.month == '11')}-->selected<--{/if}--> >11</option>
<option value="12" <--{if (isset($new_card.month) && $new_card.month == '12')}-->selected<--{/if}--> >12</option>
</select><--{__('lbl_month')}--> / 20
<select name="cardDate_y" id="cardDate02">
<--{section name=i start=$smarty.now|date_format:"%g" loop=$smarty.now|date_format:"%g" + 20}-->
<option value="<--{$smarty.section.i.index}-->" <--{if (isset($new_card.year) && $new_card.year == $smarty.section.i.index)}-->selected<--{/if}--> ><--{$smarty.section.i.index}--></option>
<--{/section}-->
</select><--{__('lbl_year')}--> <span class="note"><--{__('lbl_ex_effective_date')}--></span>
</td>
</tr>
</table>
</dd>
</dl>
<div class="policyTxt">
<p><--{__('lbl_card_message')}--></p>
</div>
<ul class="btn">
<li class="agree"><input type="submit" value="<--{__('lbl_submit_card_info')}-->"></li>
</ul>
</form>
</div>
</div>
<div class="policyBox">
<p><a href="<--{$stop_url}-->"><--{__('lbl_stop_reserve')}--></a></p>
<div class="scrollBox">
<--{__('lbl_card_policy')}-->
</div>
</div>
</section>
</div>

</div>