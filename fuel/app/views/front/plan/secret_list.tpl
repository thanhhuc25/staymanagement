<!-- contents -->
<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>

<section>
<h2><--{$secret.PLN_TYPE }--><span class="small"><--{$secret.PLN_NAME }--></span></h2>

<div class="searchBox clearfix">
<!-- <form action="" method="post"> -->
<--{Form::open("`$url`secret/list")}-->
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
<dt><--{__('lbl_person_num')}-->（<--{__('lbl_one_room')}-->）</dt>
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
<p class="btn"><input type="submit" value="<--{__('lbl_serch')}-->"></p>
<!-- </form> -->
<--{Form::close()}-->
</div>


<div class="searchList secretList">

<div class="roomList">

<--{foreach from=$plans item=value key=key}-->
<div class="roomBox">
<div class="roomTtl">
<p><--{$secret.PLN_NAME }--></p>
</div>
<--{if $secret.PLN_CAP_PC}-->
<div class="roomPrivilege">
<p><span class="ico">その他特典</span><--{$secret.PLN_CAP_PC }--></p>
</div>
<--{/if}-->

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
<p class="txt">&nbsp;</p>
<ul class="tag spHide">
<--{foreach from=$value.CATEGORYS item=item}-->

<li><--{$item}--></li>
<--{/foreach}-->
</ul>
</div>
<div class="roomPlan">
<table>
<tr>
<th class="planTtl" colspan="2"><span></span></th>
<th class="planPrice spHide">大人1名（税込)<br>通常価格</th>
<th class="planPrice spHide"><em>大人1名（税込)<br>割引価格</em></th>
<th class="planPrice spHide"><em>合計（税込)</em></th>
</tr>

<--{foreach from=$value.RTYPES item=rtype}-->

<tr>
<td<--{if $rtype.RM_OPTION == '001000'}--> style="padding-top:33px;"<--{/if}-->>
<--{if $rtype.RM_OPTION == '001000'}-->
<p class="noSmoking"><--{Asset::img('front/ico_noSmoking01.png',["alt" => "禁煙室"])}--></p>
<--{/if}-->
<p class="planName"><--{Html::anchor("`$url`plan/detail/`$value.HTL_ID`_`$value.PLN_ID`_`$rtype.TYPE_ID`_`$checkflg.otona`_`$checkflg.stayCount`_`$checkflg.room`", $rtype.TYPE_NAME)}--></p>
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
<td class="planPrice spHide"><--{$rtype.GENERAL_PAYMENT|number_format}--><--{__('lbl_yen')}-->～</td>
<td class="planPrice spHide"><em><--{$rtype.PAYMENT|number_format}--><--{__('lbl_yen')}-->～</em></td>
<td class="planPrice spHide"><--{$rtype.SUM|number_format}--><--{__('lbl_yen')}-->～</td>
<--{else}-->
<td class="planPrice spHide"><--{$rtype.GENERAL_PAYMENT|number_format}--><--{__('lbl_yen')}--></td>
<td class="planPrice spHide"><em><--{$rtype.PAYMENT|number_format}--><--{__('lbl_yen')}--></em></td>
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

</div>
</section>
</div>

</div>
<!-- /contents -->
