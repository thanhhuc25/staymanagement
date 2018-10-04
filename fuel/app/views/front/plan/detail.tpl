<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">

<--{FRONT_INC_LOGIN_MENU_HTML}-->

</div>
<div class="roomDetail">
<div class="roomTtl">
<p><--{$plan.PLN_NAME}--> / <--{$plan.TYPE_NAME}--></p>
</div>
<div class="clearfix">
<div class="roomImg">
<ul class="imgSlide clearfix">
<li><--{Asset::img($plan.IMGURL1)}--></li>
<li><--{Asset::img($plan.IMGURL2)}--></li>
<li><--{Asset::img($plan.IMGURL3)}--></li>
<li><--{Asset::img($plan.IMGURL4)}--></li>
</ul>
<ul class="imgThumb clearfix">
<li><a data-slide-index="0" href="javascript:void(0)"><--{Asset::img($plan.IMGURL1)}--></a></li>
<li><a data-slide-index="1" href="javascript:void(0)"><--{Asset::img($plan.IMGURL2)}--></a></li>
<li><a data-slide-index="2" href="javascript:void(0)"><--{Asset::img($plan.IMGURL3)}--></a></li>
<li><a data-slide-index="3" href="javascript:void(0)"><--{Asset::img($plan.IMGURL4)}--></a></li>
</ul>
</div>
<div class="roomData">
<div class="roomTable">
<table>
<!--tr>
<td><span><--{__('lbl_breakfast')}--></span><--{__('lbl_nothing')}--></td>
<td><span><--{__('lbl_dinner')}--></span><--{__('lbl_nothing')}--></td>
</tr-->
<tr>
<td><span><--{__('lbl_check_in')}--></span><--{$plan.CHECK_IN}--></td>
<td><span><--{__('lbl_check_out')}--></span>11:00</td>
</tr>
<tr>
<td><span><--{__('lbl_person_num')}--></span><--{$member_num}--></td>
<!-- <td><p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p></td> -->
</tr>
</table>
</div>
<p class="txt"><--{$plan.DESCRIPTION}--></p>
</div>
</div>
<div class="roomSection">
<div class="roomTtl">
<p><--{__('lbl_plan_detail')}--></p>
</div>
<div class="roomOutline">
<--{$plan.DESCRIPTION_LIGHT|nl2br}-->
</div>
</div>

<--{if isset($reserve.PAYMENT)}-->
<div class="roomSpec" style="background:#f8f9f9;">
<dl>
<dt><span><--{__('lbl_payment')}--></span></dt>
<dd class="total">
<table>
<tr>
<td class="price"><span class="price01"><--{__('lbl_yen_mark')}--> <--{$reserve.PAYMENT|number_format}-->(<--{__('lbl_include_tax')}-->)</span><span class="price02"></span></td>
<td class="btn">
<p><--{Html::anchor("`$htl_name`/reserve/`$reserve.URL`", __('lbl_reserve_plan'))}--></p>
</td>
</tr>
</table>
</dd>
</dl>
<dl><--{__('')}-->
<dt><span><--{__('lbl_payment_list')}--></span><span class="note"><--{__('lbl_include_tax_service')}--></span></dt>
<dd class="spec">
<table>
<tr>
<td><--{__('lbl_room_type2')}--></td>
<td><--{$plan.TYPE_NAME}--></td>
</tr>
<tr>
<td><--{__('lbl_person_num')}--> / <--{__('lbl_room_num')}--></td>
<td><--{$reserve.STAYNUM|number_format}--><--{__('lbl_person')}--> / <--{$reserve.STAYRMNUM|number_format}--><--{__('lbl_room')}--></td>
</tr>
<tr>
<td><--{__('lbl_staynum')}--></td>
<td><--{$reserve.STAYMDATENUM|number_format}--><--{__('lbl_stay')}--></td>
</tr>
<tr>
<td><--{__('lbl_check_in')}--></td>
<td><--{$reserve.CHECK_IN_STR}--></td>
</tr>
<tr>
<td><--{__('lbl_check_out')}--></td>
<td><--{$reserve.CHECK_OUT_STR}--></td>
</tr>
</table>
<p class="note"><--{__('lbl_total')}-->（<--{__('lbl_include_tax')}-->）<--{__('lbl_yen_mark')}--><--{$reserve.BASIC_PAY|number_format}--> × <--{$reserve.STAYNUM|number_format}--><--{__('lbl_person')}--> × <--{$reserve.STAYRMNUM|number_format}--><--{__('lbl_room')}--> = <--{__('lbl_yen_mark')}--><--{$reserve.PAYMENT|number_format}--></p>
</dd>
</dl>
</div>
<--{/if}-->

<div class="roomSection">
<div class="roomTtl">
<p><--{__('lbl_pay_room_status')}--></p>
</div>
<div class="roomSituation">
<p class="note "><--{__('lbl_heyasuuwo')}--><br><--{__('lbl_yoyakuha')}--></p>
<div class="roomSearch clearfix">
<!-- <form action="" method="post"> -->
<--{Form::open($action)}-->
<dl class="search01">
<dt><--{__('lbl_room_num')}--></dt>
<dd>
<select name="room" id="r_room">
<--{section name=i start=1 loop=10}-->
<--{if ($smarty.section.i.index == $rm_num)}-->
<option value="<--{$smarty.section.i.index}-->" selected="selected"><--{$smarty.section.i.index}--></option>
<--{else}-->
<option value="<--{$smarty.section.i.index}-->"><--{$smarty.section.i.index}--></option>
<--{/if}-->
<--{/section}-->
</select><--{__('lbl_room')}-->
</dd>
</dl>
<dl class="search02">
<dt><--{__('lbl_staynum')}--></dt>
<dd>
<select name="stayCount" id="r_stay">
<--{section name=i start=$plan.PLN_STAY_LOWER loop=$plan.PLN_STAY_UPPER+1}-->
<--{if ($smarty.section.i.index == $reserve.STAYMDATENUM)}-->
<option value="<--{$smarty.section.i.index}-->" selected="selected"><--{$smarty.section.i.index}--></option>
<--{else}-->
<option value="<--{$smarty.section.i.index}-->"><--{$smarty.section.i.index}--></option>
<--{/if}-->
<--{/section}-->
</select><--{__('lbl_stay')}-->
</dd>
</dl>
<p class="btn"><input type="submit" value="<--{__('lbl_recalculation')}-->"></p>
<!-- <dl class="search03 pcHide">
<dt>ご宿泊日</dt>
<dd>
<input type="text" name="ciDate" id="ciDateYMD" value="2015年8月8日"><label for="ciDateYMD"></label>
</dd>
</dl> -->
</form>
<!-- <p class="txt01 pcHide">2015年8月8日の残室数：<span>10</span>部屋以上</p>
<p class="txt02 pcHide"><a href="#">他の日の残室・料金をカレンダーで見る</a></p>
 --></div>
<div class="monthPager ">
<table>
<tr>
<td class="prev"><a href="<--{$preview_page.url}-->"><--{$preview_page.month}--><--{__('lbl_month')}--></a></td>
<td><--{$year}--><--{__('lbl_year')}--><--{$month}--><--{__('lbl_month')}--></td>
<td class="next"><a href="<--{$next_page.url}-->"><--{$next_page.month}--><--{__('lbl_month')}--></a></td>
</tr>
</table>
</div>
<div class="monthCalendar ">
<table>
<tr>
<td style="padding:2px;" class="red"><--{__('lbl_sunday')}--></td>
<td style="padding:2px;"><--{__('lbl_monday')}--></td>
<td style="padding:2px;"><--{__('lbl_tuesday')}--></td>
<td style="padding:2px;"><--{__('lbl_wednesday')}--></td>
<td style="padding:2px;"><--{__('lbl_thursday')}--></td>
<td style="padding:2px;"><--{__('lbl_friday')}--></td>
<td style="padding:2px;" class="blue"><--{__('lbl_saturday')}--></td>
</tr>




<--{assign "daycount" "1"}-->
<tr>
<--{section name=i start=1 loop=8}-->

<--{if ($smarty.section.i.index <= $empty)}-->
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<--{else}-->
<td class="<--{if ($calendar.$daycount.class == '' && $smarty.section.i.first == $smarty.section.i.index )}-->r<--{else if ($calendar.$daycount.class == '' && $smarty.section.i.last == $smarty.section.i.index)}-->b<--{else}--><--{$calendar.$daycount.class}--><--{/if}-->">
<span class="day"  <--{if (isset($calendar.$daycount.flg))}-->style="color:red; font-size: 24px;"<--{/if}--> ><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price">
<s><--{if (isset($calendar.$daycount.general_payment))}--><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.general_payment|number_format}--><--{/if}--></s><br>
<--{__('lbl_yen_mark')}--><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.payment|number_format}--></em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span></a>
<--{else}-->
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span>
<--{/if}-->
</td>
<--{assign "daycount" $daycount + 1}-->
<--{/if}-->
<--{/section}-->
</tr>


<tr>
<--{section name=i start=8 loop=15}-->
<td class="<--{if ($calendar.$daycount.class == '' && $smarty.section.i.first == $smarty.section.i.index )}-->r<--{else if ($calendar.$daycount.class == '' && $smarty.section.i.last == $smarty.section.i.index)}-->b<--{else}--><--{$calendar.$daycount.class}--><--{/if}-->">
<span class="day" <--{if (isset($calendar.$daycount.flg))}-->style="color:red; font-size: 24px;"<--{/if}--> ><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price">
<s><--{if (isset($calendar.$daycount.general_payment))}--><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.general_payment|number_format}--><--{/if}--></s><br>
<--{__('lbl_yen_mark')}--><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.payment|number_format}--></em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span></a>
<--{else}-->
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span>
<--{/if}-->
</td>

<--{assign "daycount" $daycount + 1}-->
<--{/section}-->
</tr>


<tr>
<--{section name=i start=15 loop=22}-->
<td class="<--{if ($calendar.$daycount.class == '' && $smarty.section.i.first == $smarty.section.i.index )}-->r<--{else if ($calendar.$daycount.class == '' && $smarty.section.i.last == $smarty.section.i.index)}-->b<--{else}--><--{$calendar.$daycount.class}--><--{/if}-->">
<span class="day" <--{if (isset($calendar.$daycount.flg))}-->style="color:red; font-size: 24px;"<--{/if}--> ><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price">
<s><--{if (isset($calendar.$daycount.general_payment))}--><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.general_payment|number_format}--><--{/if}--></s><br>
<--{__('lbl_yen_mark')}--><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.payment|number_format}--></em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span></a>
<--{else}-->
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span>
<--{/if}-->
</td>

<--{assign "daycount" $daycount + 1}-->
<--{/section}-->
</tr>


<tr>
<--{section name=i start=22 loop=29}-->
<td class="<--{if ($calendar.$daycount.class == '' && $smarty.section.i.first == $smarty.section.i.index )}-->r<--{else if ($calendar.$daycount.class == '' && $smarty.section.i.last == $smarty.section.i.index)}-->b<--{else}--><--{$calendar.$daycount.class}--><--{/if}-->">
<span class="day" <--{if (isset($calendar.$daycount.flg))}-->style="color:red; font-size: 24px;"<--{/if}--> ><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price">
<s><--{if (isset($calendar.$daycount.general_payment))}--><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.general_payment|number_format}--><--{/if}--></s><br>
<--{__('lbl_yen_mark')}--><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.payment|number_format}--></em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span></a>
<--{else}-->
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span>
<--{/if}-->
</td>

<--{assign "daycount" $daycount + 1}-->
<--{/section}-->
</tr>


<tr>
<--{section name=i start=29 loop=36}-->
<--{if ($days_in_month < $daycount)}-->
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<--{else}-->
<td class="<--{if ($calendar.$daycount.class == '' && $smarty.section.i.first == $smarty.section.i.index )}-->r<--{else if ($calendar.$daycount.class == '' && $smarty.section.i.last == $smarty.section.i.index)}-->b<--{else}--><--{$calendar.$daycount.class}--><--{/if}-->">
<span class="day"  <--{if (isset($calendar.$daycount.flg))}-->style="color:red; font-size: 24px;"<--{/if}--> ><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price">
<s><--{if (isset($calendar.$daycount.general_payment))}--><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.general_payment|number_format}--><--{/if}--></s><br>
<--{__('lbl_yen_mark')}--><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.payment|number_format}--></em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span></a>
<--{else}-->
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span>
<--{/if}-->
</td>
<--{/if}-->
<--{assign "daycount" $daycount + 1}-->
<--{/section}-->
</tr>

<--{if ($days_in_month >= $daycount)}-->
<tr>
<--{section name=i start=36 loop=43}-->
<--{if ($days_in_month < $daycount)}-->
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<--{else}-->
<td class="<--{if ($calendar.$daycount.class == '' && $smarty.section.i.first == $smarty.section.i.index )}-->r<--{else if ($calendar.$daycount.class == '' && $smarty.section.i.last == $smarty.section.i.index)}-->b<--{else}--><--{$calendar.$daycount.class}--><--{/if}-->">
<span class="day"  <--{if (isset($calendar.$daycount.flg))}-->style="color:red; font-size: 24px;"<--{/if}--> ><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price">
<s><--{if (isset($calendar.$daycount.general_payment))}--><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.general_payment|number_format}--><--{/if}--></s><br>
<--{__('lbl_yen_mark')}--><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{__('lbl_yen_mark')}--><--{$calendar.$daycount.payment|number_format}--></em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span></a>
<--{else}-->
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark"><--{$calendar.$daycount.mark}--></span>
<--{/if}-->
</td>
<--{/if}-->
<--{assign "daycount" $daycount + 1}-->
<--{/section}-->
</tr>
<--{/if}-->



</table>
<p style="margin-top:2px;float:right;"><span style="background:#ffff00;border:1px solid #ccc;position:relative;">　　　　</span>・・・<--{__('lbl_period_selected')}--></p>
<--{if (__('use_lang') == 'ja')}-->
<p class="txt"><--{Asset::img('front/txt_monthCalendar_01.png',  ["alt" => "カレンダーの見方"] )}--></p>
<--{elseif (__('use_lang') == 'en')}-->
<p class="txt"><--{Asset::img('front/txt_monthCalendar_02_en.png',  ["alt" => "How to use callendar"] )}--></p>
<--{elseif (__('use_lang') == 'zh-cn')}-->
<p class="txt"><--{Asset::img('front/txt_monthCalendar_02_ch.png',  ["alt" => "如何使用日历"] )}--></p>
<--{elseif (__('use_lang') == 'zh-tw')}-->
<p class="txt"><--{Asset::img('front/txt_monthCalendar_02_tw.png',  ["alt" => "如何使用日曆"] )}--></p>
<--{elseif (__('use_lang') == 'ko')}-->
<p class="txt"><--{Asset::img('front/txt_monthCalendar_02_ko.png',  ["alt" => "캘린더 사용 방법"] )}--></p>
<--{/if}-->
</div>
</div>
</div>
<div class="roomSection">
<div class="roomTtl">
<p><--{__('lbl_other_plan')}--></p>
</div>
<div class="roomPlan">
<table>
<--{foreach from=$other_plan item=item}-->
<--{if $item.PAYMENT > 0}-->
<tr>
<td>
<!-- <p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p> -->
<p class="planName"><a href="<--{$item.URL}-->"><--{$item.PLN_NAME}--></a></p>
<p class="planPrice pcHide"><--{$item.PAYMENT|number_format}--><--{__('lbl_yen')}-->～</p>
</td>
<td class="planPrice "><--{$item.PAYMENT|number_format}--><--{__('lbl_yen')}-->～</td>
<td class="planPrice "><--{$item.SUM|number_format}--><--{__('lbl_yen')}-->～</td>
</tr>
<--{/if}-->
<--{/foreach}-->
</table>
</div>
</div>

</div>

</div>

</div>
