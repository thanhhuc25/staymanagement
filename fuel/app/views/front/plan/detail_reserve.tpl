<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<div class="roomDetail">
<div class="roomTtl">
<p><--{$plan.PLN_NAME}--></p>
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
<tr>
<td><span>朝食</span>なし</td>
<td><span>夕食</span>なし</td>
</tr>
<tr>
<td><span>チェックイン</span><--{$plan.CHECK_IN}--></td>
<td><span>チェックアウト</span>10:00</td>
</tr>
<tr>
<td><span>人数</span>1</td>
<!-- <td><p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p></td> -->
</tr>
</table>
</div>
<p class="txt"><--{$plan.DESCRIPTION}--></p>
</div>
</div>
<div class="roomSection">
<div class="roomTtl">
<p>プラン詳細</p>
</div>
<div class="roomOutline">
<--{$plan.DESCRIPTION_LIGHT}-->
</div>
</div>

<div class="roomSpec">
<dl>
<dt><span>支払い料金（サービス料込）</span></dt>
<dd class="total">
<table>
<tr>
<td class="price">宿泊料金<span class="price01">￥ <--{$reserve.PAYMENT|number_format}-->(税込)</span><span class="price02"></span></td>
<td class="btn">
<p><--{Html::anchor("`$htl_name`/reserve/`$reserve.URL`", '予約へ進む')}--></p>
</td>
</tr>
</table>
</dd>
</dl>
<dl>
<dt><span>料金明細</span><span class="note">※料金はサービス料込・消費税込</span></dt>
<dd class="spec">
<table>
<tr>
<td>お部屋タイプ</td>
<td><--{$plan.TYPE_NAME}--></td>
</tr>
<tr>
<td>宿泊者数 / 客室</td>
<td><--{$reserve.STAYNUM|number_format}-->名 / <--{$reserve.STAYRMNUM|number_format}-->室</td>
</tr>
<tr>
<td>泊数</td>
<td><--{$reserve.STAYMDATENUM|number_format}-->泊</td>
</tr>
</table>
<p class="note">宿泊合計（税込）<--{$reserve.BASIC_PAY|number_format}-->円 × <--{$reserve.STAYNUM|number_format}-->人 × <--{$reserve.STAYRMNUM|number_format}-->室 × <--{$reserve.STAYMDATENUM|number_format}-->泊 = <--{$reserve.PAYMENT|number_format}-->円</p>
</dd>
</dl>
</div>

<div class="roomSection">
<div class="roomTtl">
<p>料金・空室状況</p>
</div>
<div class="roomSituation">
<p class="note spHide">部屋数を設定後、料金再計算をクリックしてください。<br>「予約」は下のカレンダーをクリックしてください。</p>
<div class="roomSearch clearfix">
<!-- <form action="" method="post"> -->
<--{Form::open(URL_PLNRECALCULATION)}-->
<dl class="search01">
<dt>部屋数</dt>
<dd>
<select name="room" id="r_room">
<--{section name=i start=1 loop=10}-->
<--{if ($smarty.section.i.index == $rm_num)}-->
<option value="<--{$smarty.section.i.index}-->" selected="selected"><--{$smarty.section.i.index}--></option>
<--{else}-->
<option value="<--{$smarty.section.i.index}-->"><--{$smarty.section.i.index}--></option>
<--{/if}-->
<--{/section}-->
</select>室
</dd>
</dl>
<dl class="search02 spHide">
<dt>泊数</dt>
<dd>
<select name="stayCount" id="r_stay">
<--{section name=i start=$plan.PLN_MIN loop=$plan.PLN_MAX+1}-->
<--{if ($smarty.section.i.index == $staydate_num)}-->
<option value="<--{$smarty.section.i.index}-->" selected="selected"><--{$smarty.section.i.index}--></option>
<--{else}-->
<option value="<--{$smarty.section.i.index}-->"><--{$smarty.section.i.index}--></option>
<--{/if}-->
<--{/section}-->
</select>泊
</dd>
</dl>
<p class="btn"><input type="submit" value="再計算"></p>
<dl class="search03 pcHide">
<dt>ご宿泊日</dt>
<dd>
<input type="text" name="ciDate" id="ciDateYMD" value="2015年8月8日"><label for="ciDateYMD"></label>
</dd>
</dl>
</form>
<p class="txt01 pcHide">2015年8月8日の残室数：<span>10</span>部屋以上</p>
<p class="txt02 pcHide"><a href="#">他の日の残室・料金をカレンダーで見る</a></p>
</div>
<div class="monthPager spHide">
<table>
<tr>
<td class="prev"><a href="<--{$preview_page.url}-->"><--{$preview_page.month}-->月</a></td>
<td><--{$year}-->年<--{$month}-->月</td>
<td class="next"><a href="<--{$next_page.url}-->"><--{$next_page.month}-->月</a></td>
</tr>
</table>
</div>
<div class="monthCalendar spHide">
<table>
<tr>
<th>月</th>
<th>火</th>
<th>水</th>
<th>木</th>
<th>金</th>
<th>土</th>
<th>日</th>
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
<td class="<--{$calendar.$daycount.class}-->">
<span class="day"><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price"><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{$calendar.$daycount.payment|number_format}--></em></span>
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
<td class="<--{$calendar.$daycount.class}-->">
<span class="day"><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price"><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{$calendar.$daycount.payment|number_format}--></em></span>
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
<td class="<--{$calendar.$daycount.class}-->">
<span class="day"><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price"><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{$calendar.$daycount.payment|number_format}--></em></span>
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
<td class="<--{$calendar.$daycount.class}-->">
<span class="day"><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price"><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{$calendar.$daycount.payment|number_format}--></em></span>
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
<td class="<--{$calendar.$daycount.class}-->">
<span class="day"><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price"><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{$calendar.$daycount.payment|number_format}--></em></span>
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

<--{if ($days_in_month > $daycount)}-->
<tr>
<--{section name=i start=36 loop=43}-->
<--{if ($days_in_month < $daycount)}-->
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<--{else}-->
<td class="<--{$calendar.$daycount.class}-->">
<span class="day"><--{$daycount}--></span>
<--{if ( $calendar.$daycount.stopflg == 0 && $calendar.$daycount.stock > 0)}--><a href="<--{$calendar.$daycount.url}-->">
<span class="price"><--{($calendar.$daycount.payment * $reserve.STAYNUM)|number_format }--><em><--{$calendar.$daycount.payment|number_format}--></em></span>
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



<!-- <tr>
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td>
<span class="day">&nbsp;</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">1</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">2</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">3</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
</tr>
<tr>
<td class="bg01">
<span class="day">4</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">5</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">6</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">7</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">8</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">9</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">10</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
</tr>
<tr>
<td class="bg01">
<span class="day">11</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">12</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">13</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">14</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">15</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">16</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="bg01">
<span class="day">17</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
</tr>
<tr>
<td class="bg01">
<span class="day">18</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">&nbsp;</span>
</td>
<td class="gray"><a href="#">
<span class="day">19</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">1</span>
</a></td>
<td><a href="#">
<span class="day">20</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td class="red"><a href="#">
<span class="day">21</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td><a href="#">
<span class="day">22</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td><a href="#">
<span class="day">23</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td>
<span class="day">24</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">×</span>
</td>
</tr>
<tr>
<td>
<span class="day">25</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">×</span>
</td>
<td><a href="#">
<span class="day">26</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">1</span>
</a></td>
<td><a href="#">
<span class="day">27</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td><a href="#">
<span class="day">28</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td><a href="#">
<span class="day">29</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td><a href="#">
<span class="day">30</span>
<span class="price">&yen;14,000<em>&yen;7,100</em></span>
<span class="mark">○</span>
</a></td>
<td>
<span class="day">31</span>
<span class="price">&nbsp;<em>&nbsp;</em></span>
<span class="mark">×</span>
</td>
</tr> -->
</table>
<p class="txt"><--{Asset::img('front/txt_monthCalendar_01.png',  ["alt" => "カレンダーの見方"] )}--></p>
</div>
</div>
</div>
<div class="roomSection">
<div class="roomTtl">
<p>その他のプラン</p>
</div>
<div class="roomPlan">
<table>
<tr>
<td>
<p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p>
<p class="planName"><a href="#">【早割】28日前までの予約が断然お得！早割２８プラン　(素泊まり) </a></p>
<p class="planPrice pcHide">5,700円～</p>
</td>
<td class="planPrice spHide">5,700円～</td>
<td class="planPrice spHide">15,700円～</td>
</tr>
<tr>
<td>
<p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p>
<p class="planName"><a href="#">【早割】28日前までの予約が断然お得！早割２８プラン　(素泊まり) </a></p>
<p class="planPrice pcHide">5,700円～</p>
</td>
<td class="planPrice spHide">5,700円～</td>
<td class="planPrice spHide">15,700円～</td>
</tr>
<tr>
<td>
<p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p>
<p class="planName"><a href="#">【早割】28日前までの予約が断然お得！早割２８プラン　(素泊まり) </a></p>
<p class="planPrice pcHide">5,700円～</p>
</td>
<td class="planPrice spHide">5,700円～</td>
<td class="planPrice spHide">15,700円～</td>
</tr>
<tr>
<td>
<p class="noSmoking"><img src="/images/ico_noSmoking01.png" alt="禁煙室"></p>
<p class="planName"><a href="#">【早割】28日前までの予約が断然お得！早割２８プラン　(素泊まり) </a></p>
<p class="planPrice pcHide">5,700円～</p>
</td>
<td class="planPrice spHide">5,700円～</td>
<td class="planPrice spHide">15,700円～</td>
</tr>
</table>
</div>
</div>

</div>

</div>

</div>
