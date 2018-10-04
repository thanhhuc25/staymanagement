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
<td><--{$ciTime}--></td>
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
<td><--{$ADJUST_TYPE}--></td>
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
<ul class="btn">
<li><input type="submit" value="<--{__('lbl_confirm')}-->"></li>
</ul>
</form>
</div>
</section>
</div>
</section>
</div>

</div>
