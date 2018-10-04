<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>


<h2><--{__('lbl_mypage')}--><span class="ttlbtn"><a href="<--{$edit_url}-->"><span><--{__('lbl_edit_account2')}--></span></a></span></h2>
<p style="color: red;"><--{$error}--></p>
<div class="mypageBox">
<section style="display:none;">
<h3><--{__('lbl_stamp')}--></h3>
<div class="stampTable">
<p><--{__('lbl_stamp_five')}--><--{__('lbl_yen_mark')}--><--{DISCOUNT}--><--{__('lbl_waribiki')}--></p>
<ul class="stampList clearfix">
<li class="stamp01"><span><--{if ($user.USR_POINTS >=1)}--><--{Asset::img('front/ico_stamp01.png')}--><--{/if}--></span></li>
<li class="stamp02"><span><--{if ($user.USR_POINTS >=2)}--><--{Asset::img('front/ico_stamp01.png')}--><--{/if}--></span></li>
<li class="stamp03"><span><--{if ($user.USR_POINTS >=3)}--><--{Asset::img('front/ico_stamp01.png')}--><--{/if}--></span></li>
<li class="stamp04"><span><--{if ($user.USR_POINTS >=4)}--><--{Asset::img('front/ico_stamp01.png')}--><--{/if}--></span></li>
<li class="stamp05"><span><--{if ($user.USR_POINTS >=5)}--><--{Asset::img('front/ico_stamp01.png')}--><--{/if}--></span></li>
</ul>
</div>

</section>

<section>
<h3><--{__('lbl_rsv_list')}--></h3>

<--{foreach from=$rsv key=key item=item}-->
<div class="reserveTable">
<p class="reserveTtl"><--{$key + 1}-->　<--{$item.PLN_NAME}--></p>
<div class="clearfix">
<table>
<tr>
<th><--{__('lbl_rsv_no')}--></th>
<td>stm<--{$item.RSV_NO}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_room_type')}--></th>
<td><--{$item.TYPE_NAME}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_room_num')}--></th>
<td><--{$item.NUM_ROOM}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_person_num')}--></th>
<td><--{$item.num}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_arrive_date')}--></th>
<td><--{if (__('use_lang') == 'ja')}--><--{$item.IN_DATE|date_format:"%Y年%-m月%-d日"}--><--{else}--><--{$item.IN_DATE|date_format:"%Y / %-m / %-d"}--><--{/if}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_arrive_time')}--></th>
<td><--{$item.IN_DATE_TIME|date_format:"%p%-I:%M"}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_leave_date')}--></th>
<td><--{if (__('use_lang') == 'ja')}--><--{$item.OUT_DATE|date_format:"%Y年%-m月%-d日"}--><--{else}--><--{$item.OUT_DATE|date_format:"%Y / %-m / %-d"}--><--{/if}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_staynum')}--></th>
<td><--{$item.NUM_STAY}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_adjust_type')}--></th>
<td><--{if ($item.ADTYPE==1)}--><--{__('lbl_front')}--><--{else}--><--{__('lbl_credit')}--><--{/if}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_payment')}--></th>
<td><--{__('lbl_yen_mark')}--><--{$item.PLN_CHG_TOTAL|number_format}--></td>
</tr>
</table>
<table>
<tr>
<th><--{__('lbl_plan_name')}--></th>
<td><--{$item.PLN_NAME}--></td>
</tr>
</table>
</div>
<p class="btn"><a href="<--{$item.URL}-->"><--{__('lbl_change_cancel')}--></a></p>
</div>
<--{/foreach}-->


</section>
</div>
</section>
</div>

</div>
