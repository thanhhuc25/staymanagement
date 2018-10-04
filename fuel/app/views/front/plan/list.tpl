<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<div class="searchBox clearfix">
<!-- <form action="" method="post"> -->
<--{Form::open("`$url`plan/search")}-->
<dl class="search01">
<dt><--{__('lbl_satydate')}-->・<--{__('lbl_staynum')}--></dt>
<dd>
<input type="text" name="ciDate" id="ciDateYMD" value="<--{$checkflg.dateVal}-->"><label for="ciDateYMD"></label>
<input type="checkbox" name="ciDate" id="ciDateU" <--{$checkflg.date}--> ><label for="ciDateU"><--{__('lbl_unclearly_date')}--></label>
<select name="stayCount" id="r_stay">
<option value="1" <--{if (isset($stay_flg.1) )}-->selected="selected"<--{/if}--> >1</option>
<option value="2" <--{if (isset($stay_flg.2) )}-->selected="selected"<--{/if}--> >2</option>
<option value="3" <--{if (isset($stay_flg.3) )}-->selected="selected"<--{/if}--> >3</option>
<option value="4" <--{if (isset($stay_flg.4) )}-->selected="selected"<--{/if}--> >4</option>
<option value="5" <--{if (isset($stay_flg.5) )}-->selected="selected"<--{/if}--> >5</option>
<option value="6" <--{if (isset($stay_flg.6) )}-->selected="selected"<--{/if}--> >6</option>
<option value="7" <--{if (isset($stay_flg.7) )}-->selected="selected"<--{/if}--> >7</option>
</select><--{__('lbl_stay')}-->
</dd>
</dl>
<dl class="search02">
<dt><--{__('lbl_person_num')}-->(<--{__('lbl_one_room')}-->)</dt>
<dd>
<select name="otona" id="r_peple">

<option value="1" <--{if (isset($otona_flg.1) )}-->selected="selected"<--{/if}--> >1</option>
<option value="2" <--{if (isset($otona_flg.2) )}-->selected="selected"<--{/if}--> >2</option>
<option value="3" <--{if (isset($otona_flg.3) )}-->selected="selected"<--{/if}--> >3</option>
<option value="4" <--{if (isset($otona_flg.4) )}-->selected="selected"<--{/if}--> >4</option>
<option value="5" <--{if (isset($otona_flg.5) )}-->selected="selected"<--{/if}--> >5</option>
<option value="6" <--{if (isset($otona_flg.6) )}-->selected="selected"<--{/if}--> >6</option>

</select><--{__('lbl_person')}-->
</dd>
</dl>
<dl class="search03">
<dt><--{__('lbl_gender')}--></dt>
<dd>
<!-- <input type="radio" name="gender" id="gender01" value="1" <--{$checkflg.man}--> ><label for="gender01"><--{__('lbl_man')}--></label> -->
<!-- <input type="radio" name="gender" id="gender02" value="2" <--{$checkflg.woman}--> ><label for="gender02"><--{__('lbl_woman')}--></label> -->
<input type="checkbox" name="gender" id="gender02" value="2" <--{$checkflg.woman}--> ><label for="gender02"><--{__('lbl_woman_only')}--></label>
</dd>
</dl>
<dl class="search04">
<dt><--{__('lbl_room_num')}--></dt>
<dd>
<select name="room" id="r_room">
<option value="1"  <--{if (isset($room_flg.1) )}-->selected="selected"<--{/if}--> >1</option>
<option value="2"  <--{if (isset($room_flg.2) )}-->selected="selected"<--{/if}--> >2</option>
<option value="3"  <--{if (isset($room_flg.3) )}-->selected="selected"<--{/if}--> >3</option>
<option value="4"  <--{if (isset($room_flg.4) )}-->selected="selected"<--{/if}--> >4</option>
<option value="5"  <--{if (isset($room_flg.5) )}-->selected="selected"<--{/if}--> >5</option>
<option value="6"  <--{if (isset($room_flg.6) )}-->selected="selected"<--{/if}--> >6</option>
<option value="7"  <--{if (isset($room_flg.7) )}-->selected="selected"<--{/if}--> >7</option>
<option value="8"  <--{if (isset($room_flg.8) )}-->selected="selected"<--{/if}--> >8</option>
<option value="9"  <--{if (isset($room_flg.9) )}-->selected="selected"<--{/if}--> >9</option>
<option value="10" <--{if (isset($room_flg.10) )}-->selected="selected"<--{/if}--> >10</option>
</select><--{__('lbl_room')}-->
</dd>
</dl>
<dl class="search05">
<dt><--{__('lbl_payment')}-->(<--{__('lbl_hitoriippaku')}-->)</dt>
<dd>
<select name="price_lower" id="price_r">
<option value="1"     <--{if (isset($lower_flg.1) )}-->selected="selected"<--{/if}--> ><--{__('lbl_no_lower_limit')}--></option>
<option value="5000"  <--{if (isset($lower_flg.5000) )}-->selected="selected"<--{/if}--> >5,000</option>
<option value="7000"  <--{if (isset($lower_flg.7000) )}-->selected="selected"<--{/if}--> >7,000</option>
<option value="10000" <--{if (isset($lower_flg.10000) )}-->selected="selected"<--{/if}--> >10,000</option>

</select><--{__('lbl_yen')}--> ～
<select name="price_upper" id="price_h">
<option value="10000"     <--{if (isset($upper_flg.10000) )}-->selected="selected"<--{/if}--> >10,000</option>
<option value="15000"     <--{if (isset($upper_flg.15000) )}-->selected="selected"<--{/if}--> >15,000</option>
<option value="20000"     <--{if (isset($upper_flg.20000) )}-->selected="selected"<--{/if}--> >20,000</option>
<option value="100000000" <--{if (isset($upper_flg.100000000) )}-->selected="selected"<--{/if}--> ><--{__('lbl_no_upper_limit')}--></option>
</select><--{__('lbl_yen')}-->
</dd>
</dl>
<p class="btn" style="margin-bottom:20px;"><input type="submit" value="<--{__('lbl_serch')}-->"></p>
<p><--{__('lbl_domitory_notice')}--></p>
<!-- </form> -->
<--{Form::close()}-->
</div>
<div class="searchList">
<div class="sort clearfix">
<ul class="clearfix">
<li><--{__('lbl_sort')}--></li>

<--{if ($flg == 1)}-->
<li class="current">[ <--{Html::anchor("javascript:void(0);", <--{__('lbl_cheap')}-->)}--> ]</li>
<--{else}-->
<li>[ <--{Html::anchor("`$url`plan/sort?sort=1", <--{__('lbl_cheap')}-->)}--> ]</li>
<--{/if}-->

<--{if ($flg == 2)}-->
<li class="current">[ <--{Html::anchor("javascript:void(0);", <--{__('lbl_rich')}-->)}--> ]</li>
<--{else}-->
<li>[ <--{Html::anchor("`$url`plan/sort?sort=2", <--{__('lbl_rich')}-->)}--> ]</li>
<--{/if}-->

<--{if ($flg == 3)}-->
<li class="current">[ <--{Html::anchor("javascript:void(0);", <--{__('lbl_recommend')}-->)}--> ]</li>
<--{else}-->
<li>[ <--{Html::anchor("`$url`plan/sort?sort=3", <--{__('lbl_recommend')}-->)}--> ]</li>
<--{/if}-->

</ul>
<p style="color: red;"><--{$error}--></p>
<p class="results"><span><--{$num}--></span><--{__('lbl_kenarimasu')}--></p>
</div>
<div class="pager clearfix">
<ul>
<li><--{Html::anchor("`$url`plan/page/`$preview_page`", '&lt;')}--></li>
<--{section name=i start=1 loop=$last_page + 1}-->
<--{if ($smarty.section.i.index == $current_page)}-->
<li class="current"><--{Html::anchor("javascript:void(0);", $smarty.section.i.index)}--></li>
<--{else}-->
<li><--{Html::anchor("`$url`plan/page/`$smarty.section.i.index`", $smarty.section.i.index)}--></li>
<--{/if}-->
<--{/section}-->
<li><--{Html::anchor("`$url`plan/page/`$next_page`", '&gt;')}--></li>
</ul>
</div>

<div class="roomList">

<--{foreach from=$plans item=value key=key}-->
<div class="roomBox">
<div class="roomTtl">
<p><--{$value.PLN_NAME}--></p>
</div>
<div class="clearfix">
<div class="roomImg">
<--{if isset($value.IMGURL1)}-->
<p><a href="#frame<--{$key+1}-->" class="colorbox"><--{Asset::img($value.IMGURL1)}--></a></p>
<--{/if}-->
<ul class="clearfix">
<--{if isset($value.IMGURL2)}-->
<li><a href="#frame<--{$key+1}-->" class="colorbox"><--{Asset::img($value.IMGURL2)}--></a></li>
<--{/if}-->
<--{if isset($value.IMGURL3)}-->
<li><a href="#frame<--{$key+1}-->" class="colorbox"><--{Asset::img($value.IMGURL3)}--></a></li>
<--{/if}-->
<--{foreach from=$value.RTYPES item=rtype}-->
<li><a href="#frame<--{$key+1}-->" class="colorbox"><--{Asset::img($rtype.IMG)}--></a></li>
<--{/foreach}-->

</ul>
</div>
<div style="display:none;">
<div class="roomFrame" id="frame<--{$key+1}-->">
<ul class="clearfix">
<--{if isset($value.IMGURL1)}-->
<li><--{Asset::img($value.IMGURL1)}--></li>
<--{/if}-->
<--{if isset($value.IMGURL2)}-->
<li><--{Asset::img($value.IMGURL2)}--></li>
<--{/if}-->
<--{if isset($value.IMGURL3)}-->
<li><--{Asset::img($value.IMGURL3)}--></li>
<--{/if}-->
<--{foreach from=$value.RTYPES item=rtype}-->
<li><a href="#frame<--{$key+1}-->" class="colorbox"><--{Asset::img($rtype.IMG)}--></a></li>
<--{/foreach}-->
</ul>
</div>
</div>
<div class="roomTxt">
<p class="txt"></p>
<ul class="tag spHide">
<--{foreach from=$value.CATEGORYS item=item}-->

<li><--{$item}--></li>
<--{/foreach}-->
</ul>
</div>
<div class="roomPlan">
<table>
<tr>
<th class="planTtl" colspan="2"><span><--{__('lbl_recommend_plan')}--></span></th>
<th class="planPrice spHide"><--{__('lbl_one_adlut')}-->(<--{__('lbl_include_tax')}-->)</th>
<th class="planPrice spHide"><--{__('lbl_total')}-->(<--{__('lbl_include_tax')}-->)</th>
</tr>
<--{foreach from=$value.RTYPES item=rtype}-->

<tr>
<td>
<--{if $rtype.RM_OPTION == '001000'}-->
<p class="noSmoking"><--{Asset::img('front/ico_noSmoking01.png',["alt" => "禁煙室"])}--></p>
<--{/if}-->
<--{if ($checkflg.date == 'checked')}-->
<p class="planName"><--{Html::anchor("`$url`plan/detail/`$value.HTL_ID`_`$value.PLN_ID`_`$rtype.TYPE_ID`_`$checkflg.otona`_`$checkflg.stayCount`_`$checkflg.room`", $rtype.TYPE_NAME)}--></p>
<--{else}-->
<p class="planName"><--{Html::anchor("`$url`plan/detail/`$value.HTL_ID`_`$value.PLN_ID`_`$rtype.TYPE_ID`_`$checkflg.otona`_`$checkflg.stayCount`_`$checkflg.room`_`$checkflg.staydate`", $rtype.TYPE_NAME)}--></p>
<--{/if}-->
<p class="planPrice pcHide"><--{$rtype.PAYMENT|number_format}--><--{__('lbl_yen')}-->～</p>
</td>
<td class="btn">
<--{if ($checkflg.date == 'checked')}-->
<!-- <p><--{Html::anchor("plan/detail/`$value.HTL_ID`_`$value.PLN_ID`_`$rtype.TYPE_ID`_`$checkflg.otona`", 'プランを予約')}--></p> -->
<--{else}-->
<p><--{Html::anchor("`$url`reserve/`$value.HTL_ID`_`$value.PLN_ID`_`$rtype.TYPE_ID`_`$checkflg.otona`_`$checkflg.stayCount`_`$checkflg.room`_`$checkflg.staydate`", <--{__('lbl_reserve_plan')}-->)}--></p>
<--{/if}-->
</td>
<--{if ($checkflg.date == 'checked')}-->
<td class="planPrice spHide"><--{$rtype.PAYMENT|number_format}--><--{__('lbl_yen')}-->～</td>
<td class="planPrice spHide"><--{$rtype.SUM|number_format}--><--{__('lbl_yen')}-->～</td>
<--{else}-->
<td class="planPrice spHide"><--{$rtype.PAYMENT|number_format}--><--{__('lbl_yen')}--></td>
<td class="planPrice spHide"><--{$rtype.SUM|number_format}--><--{__('lbl_yen')}--></td>
<--{/if}-->
</tr>


<--{/foreach}-->
</table>
</div>
</div>
</div>
<--{/foreach}-->


</div>
<div class="pager clearfix">
<ul>
<li><--{Html::anchor("`$url`plan/page/`$preview_page`", '&lt;')}--></li>
<--{section name=i start=1 loop=$last_page + 1}-->
<--{if ($smarty.section.i.index == $current_page)}-->
<li class="current"><--{Html::anchor("javascript:void(0);", $smarty.section.i.index)}--></li>
<--{else}-->
<li><--{Html::anchor("`$url`plan/page/`$smarty.section.i.index`", $smarty.section.i.index)}--></li>
<--{/if}-->
<--{/section}-->
<li><--{Html::anchor("`$url`plan/page/`$next_page`", '&gt;')}--></li>
</ul>
</div>
</div>
</div>

</div>
<!-- /contents -->
