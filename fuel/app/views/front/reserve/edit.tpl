<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2><--{__('lbl_mypage')}--></h2>
<div class="mypageBox">
<section>
<h3><--{__('lbl_change_reserve')}--></h3>
<div class="reserveEdit">
<--{Form::open($action)}-->
<input type="hidden" name="RSV_NO" value="<--{$RSV_NO}-->">
<input type="hidden" name="<--{Config::get('security.csrf_token_key')}-->" value="<--{Security::fetch_token()}-->">
<p class="reserveTtl"><--{$PLN_NAME}--></p>
<table>
<tr>
<th><--{__('lbl_rsv_no')}--></th>
<td>stm<--{$RSV_NO}--></td>
</tr>
<tr>
<th><--{__('lbl_room_type')}--></th>
<td><--{$TYPE_NAME}--></td>
</tr>
<tr>
<th><--{__('lbl_room_num')}--></th>
<td><--{$NUM_ROOM}--></td>
</tr>
<tr>
<th><--{__('lbl_person_num')}--></th>
<td><--{$num}--></td>
</tr>
<tr>
<th><--{__('lbl_arrive_date')}--></th>
<td><--{if (__('use_lang') == 'ja')}--><--{$IN_DATE|date_format:"%Y年%-m月%-d日"}--><--{else}--><--{$IN_DATE|date_format:"%Y / %-m / %-d"}--><--{/if}--></td>
</tr>
<tr>
<th><--{__('lbl_arrive_time')}--></th>
<--{if ($no_change_flg != 1)}-->
<td><--{__('lbl_setting_time')}--><select name="ciTime" id="ciTime01">
<--{foreach from=$chekin_times item=item}-->
<option value="<--{$item}-->" <--{if ($IN_DATE_TIME == $item)}-->selected="selected"<--{/if}--> ><--{$item}--></option>
<--{/foreach}-->
</select></td>
<--{else}--><td><--{$IN_DATE_TIME}--></td><--{/if}-->
</tr>
<tr>
<th><--{__('lbl_leave_date')}--></th>
<td><--{if (__('use_lang') == 'ja')}--><--{$OUT_DATE|date_format:"%Y年%-m月%-d日"}--><--{else}--><--{$OUT_DATE|date_format:"%Y / %-m / %-d"}--><--{/if}--></td>
</tr>
<tr>
<th><--{__('lbl_staynum')}--></th>
<td><--{$NUM_STAY}--></td>
</tr>
<tr>
<th><--{__('lbl_adjust_type')}--></th>
<--{if ($ADTYPE == 1)}-->
<td><--{__('lbl_front')}-->  <--{if ($no_change_flg == 0)}--><a href="<--{$action_adjust}-->" style="display:none;"><--{__('lbl_change_adjust')}--></a><--{/if}--></td>
<--{else}-->
<td><--{__('lbl_credit')}--></td>
<--{/if}-->
</tr>
<tr>
<th><--{__('lbl_payment')}--></th>
<td><--{__('lbl_yen_mark')}--><--{$PLN_CHG_TOTAL|number_format}--></td>
</tr>
<tr>
<th><--{__('lbl_plan_name')}--></th>
<td><--{$PLN_NAME}--></td>
</tr>
</table>

<--{if ($cancel_flg == 1)}-->
<label><--{__('lbl_cansel_warning')}--></label>
<--{/if}-->


<--{if ($no_change_flg == 1)}-->
<br>
<label><--{__('lbl_cansel_warning2')}--></label>
<--{/if}-->

<ul class="btn">
<--{if ($cancel_flg == 0)}-->
<li class="back"><input type="button" value="<--{__('lbl_to_cancel')}-->" onclick="cancel('<--{$htl}-->');"></li>
<--{/if}-->
<--{if ($no_change_flg == 0)}-->
<li><input type="submit" value="<--{__('lbl_to_change_confirm')}-->"></li>
<--{/if}-->
</ul>
</form>
</div>
</section>
</div>
</section>
</div>

</div>
