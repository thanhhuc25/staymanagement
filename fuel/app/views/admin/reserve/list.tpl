<div id="contents">
<div class="inner">
<h2>予約管理</h2>
<div class="editTop reserveEditTop">
<div class="tableSearch">
<h3>検索条件</h3>
<p class="leadTxt">検索したい項目にチェックし、検索内容を入力して「検索する」ボタンをクリックしてください。<br>※全項目にチェックを入れない場合は、登録されているすべての顧客情報を表示します。</p>

<--{Form::open('admin/reserve/search')}-->
<ul class="searchList clearfix">
<--{* <li><dl>
<dt><input type="checkbox" name="facilityCB" id="facility01" <--{$HTL_CB_FLG}--> ><label for="facility01">施設：</label></dt>
<dd><select name="facility" id="facility02">
<--{foreach from=$htls item=item}-->
<option value="<--{$item.HTL_NAME}-->"><--{$item.HTL_NAME}--></option>
<--{/foreach}-->

</select></dd>
</dl></li> *}-->
<li class="col3"><dl>
<dt><input type="checkbox" name="reserveNumCB" id="reserveNum01" <--{$RSV_NO_CB_FLG}--> ><label for="reserveNum01">予約番号：</label></dt>
<dd><input type="text" name="reserveNum" id="reserveNum02" value="<--{if (isset($form.reserveNum))}--><--{$form.reserveNum}--><--{/if}-->" ></dd>
</dl></li>
<li class="col3"><dl>
<dt><input type="checkbox" name="reserveNameCB" id="reserveName01" <--{$USR_NAME_CB_FLG}--> ><label for="reserveName01">顧客名：</label></dt>
<dd><input type="text" name="reserveName" id="reserveName02" value="<--{if (isset($form.reserveName))}--><--{$form.reserveName}--><--{/if}-->" ></dd>
</dl></li>
<li class="col3"><dl>
<dt><input type="checkbox" name="reserveMailCB" id="reserveMail01" <--{$MAIL_CB_FLG}--> ><label for="reserveMail01">メールアドレス：</label></dt>
<dd><input type="text" name="reserveMail" id="reserveMail02" value="<--{if (isset($form.reserveMail))}--><--{$form.reserveMail}--><--{/if}-->"></dd>
</dl></li>
<li class="col2"><dl>
<dt><input type="checkbox" name="reservePlanCB" id="reservePlan01" <--{$PLN_NAME_CB_FLG}--> ><label for="reservePlan01">プラン名：</label></dt>
<dd><input type="text" name="reservePlan" id="reservePlan02" value="<--{if (isset($form.reservePlan))}--><--{$form.reservePlan}--><--{/if}-->"></dd>
</dl></li>
<li class="col2"><dl>
<dt><input type="checkbox" name="reserveRoomCB" id="reserveRoom01" <--{$ROOM_NAME_CB_FLG}--> ><label for="reserveRoom01">部屋タイプ：</label></dt>
<dd><input type="text" name="reserveRoom" id="reserveRoom02" value="<--{if (isset($form.reserveRoom))}--><--{$form.reserveRoom}--><--{/if}-->"></dd>
</dl></li>
<li class="col2"><dl>
<dt><input type="checkbox" name="checkinTimeCB" id="checkinTime01" <--{$CI_CB_FLG}--> ><label for="checkinTime01">チェックイン：</label></dt>
<dd class="term"><ul class="clearfix">
<li><input type="text" name="checkinTime1" id="checkinTime02" value="<--{if (isset($form.checkinTime1))}--><--{$form.checkinTime1}--><--{/if}-->" ><label for="checkinTime02"></label></li>
<li><span>～</span></li>
<li><input type="text" name="checkinTime2" id="checkinTime03" value="<--{if (isset($form.checkinTime2))}--><--{$form.checkinTime2}--><--{/if}-->" ><label for="checkinTime03"></label></li>
</ul></dd>
</dl></li>
<li class="col2"><dl>
<dt><input type="checkbox" name="checkoutTimeCB" id="checkoutTime01" <--{$CO_CB_FLG}--> ><label for="checkoutTime01">チェックアウト：</label></dt>
<dd class="term"><ul class="clearfix">
<li><input type="text" name="checkoutTime1" id="checkoutTime02" value="<--{if (isset($form.checkoutTime1))}--><--{$form.checkoutTime1}--><--{/if}-->" ><label for="checkoutTime02"></label></li>
<li><span>～</span></li>
<li><input type="text" name="checkoutTime2" id="checkoutTime03" value="<--{if (isset($form.checkoutTime2))}--><--{$form.checkoutTime2}--><--{/if}-->" ><label for="checkoutTime03"></label></li>
</ul></dd>
</dl></li>
<li><dl>
<dt><input type="checkbox" name="reserveStatusCB" id="reserveStatus01" <--{$RSV_STS_CB_FLG}--> ><label for="reserveStatus01">状況：</label></dt>
<dd><ul class="clearfix">
<!-- <li><input type="radio" name="reserveStatusRB" id="reserveStatus02" value="0" <--{$RSV_STS_FLG1}--> ><label for="reserveStatus02">仮予約</label></li> -->
<li><input type="radio" name="reserveStatusRB" id="reserveStatus03" value="1" <--{$RSV_STS_FLG2}--> ><label for="reserveStatus03">予約確定</label></li>
<li><input type="radio" name="reserveStatusRB" id="reserveStatus04" value="9" <--{$RSV_STS_FLG3}--> ><label for="reserveStatus04">キャンセル</label></li>
</ul></dd>
</dl></li>
<li><dl>
<dt><input type="checkbox" name="reserveComeStatusCB" id="reserveComeStatus01" <--{$RSV_COME_STS_CB_FLG}--> ><label for="reserveComeStatus01">来店状況：</label></dt>
<dd><ul class="clearfix">
<li><input type="radio" name="reserveComeStatusRB" id="reserveComeStatus02" value="0" <--{$RSV_COME_STS_FLG1}--> ><label for="reserveComeStatus02">不明</label></li>
<li><input type="radio" name="reserveComeStatusRB" id="reserveComeStatus03" value="1" <--{$RSV_COME_STS_FLG2}--> ><label for="reserveComeStatus03">来店済み</label></li>
<li><input type="radio" name="reserveComeStatusRB" id="reserveComeStatus04" value="9" <--{$RSV_COME_STS_FLG3}--> ><label for="reserveComeStatus04">NO SHOW</label></li>
</ul></dd>
</dl></li>
<li><dl>
<dt><input type="checkbox" name="reservePaymentCB" id="reservePayment01" <--{$AD_TYPE_CB_FLG}--> ><label for="reservePayment01">支払方法：</label></dt>
<dd><ul class="clearfix">
<li><input type="radio" name="reservePaymentRB" id="reservePayment02" value="1" <--{$AD_TYPE_RB_FLG1}--> ><label for="reservePayment02">フロント精算</label></li>
<li><input type="radio" name="reservePaymentRB" id="reservePayment03" value="2" <--{$AD_TYPE_RB_FLG2}--> ><label for="reservePayment03">オンラインカード決済</label></li>
<li><input type="radio" name="reservePaymentRB" id="reservePayment04" value="0" <--{$AD_TYPE_RB_FLG3}--> ><label for="reservePayment04">両方</label></li>
</ul></dd>
</dl></li>
</ul>
<p class="btn"><input type="submit" name="search" value="検索する"></p>
</form>
</div>
<div class="tablePager clearfix">
<p style="color: red;"><--{$error}--></p>
<table class="pager">
<tr>
<--{Form::open("admin/reserve/page/`$first_page`")}-->
<td><input type="submit" name="first" value="" ></td>
<--{Form::close()}-->
<--{Form::open("admin/reserve/page/`$preview_page`")}-->
<td><input type="submit" name="prev" value="" ></td>
<--{Form::close()}-->
<--{Form::open("admin/reserve/page/`$next_page`")}-->
<td><--{$all_data_count}-->件中<--{$start_count}-->-<--{$rsv_data_count}-->件目</td>
<td><input type="submit" name="next" value="" ></td>
<--{Form::close()}-->
<--{Form::open("admin/reserve/page/`$last_page`")}-->
<td><input type="submit" name="last" value="" ></td>
<--{Form::close()}-->
<td><select name="limit" id="limit" onChange="limit_change()">
<option value="5"  <--{if ($limit_num == 5 )}-->selected<--{/if}--> >5</option>
<option value="10" <--{if ($limit_num == 10)}-->selected<--{/if}--> >10</option>
<option value="20" <--{if ($limit_num == 20)}-->selected<--{/if}--> >20</option>
</select>件ずつ表示</td>
</tr>
</table>
</div>
<--{Form::open("admin/reserve/change_sts")}-->
<div class="tableCheck tableCheckTop clearfix">
<table class="planCheck">
<tr>
<td><input type="button" name="checkAll" value="全てをチェックする"></td>
<td><input type="button" name="removeAll" value="全てのチェックをはずす"></td>
<td>チェックした予約情報のステータスを変更
<div class="edit">
<input type="button" name="editAll">
<ul class="balloon">
<li><input type='submit' name='action' value='来店済'></li>
<!-- <li><input type='submit' name='action' value='キャンセルにする'></li> -->
<li><input type='submit' name='action' value='NS'></li>
</ul>
</div>
</td>
</tr>
</table>
</div>

<div class="tableInner">
<table>
<tr>
<th>来店<span class="updown"><a href="/admin/reserve/sort/0/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/0/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>施設名<span class="updown"><a href="/admin/reserve/sort/1/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/1/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th><span>予約番号<br>（予約日時）</span><span class="updown"><a href="/admin/reserve/sort/2/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/2/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th><span>更新日時</span><span class="updown"><a href="/admin/reserve/sort/13/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/13/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>ゲスト名<span class="updown"><a href="/admin/reserve/sort/3/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/3/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th><span>チェック<br>イン</span><span class="updown"><a href="/admin/reserve/sort/4/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/4/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th><span>チェック<br>アウト</span><span class="updown"><a href="/admin/reserve/sort/5/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/5/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>泊数<span class="updown"><a href="/admin/reserve/sort/6/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/6/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>状況<span class="updown"><a href="/admin/reserve/sort/7/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/7/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>プラン名<span class="updown"><a href="/admin/reserve/sort/8/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/8/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>部屋タイプ<span class="updown"><a href="/admin/reserve/sort/12/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/12/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th class="payment"><span>支払<br>方式</span><span class="updown"><a href="/admin/reserve/sort/9/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/9/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>金額<span class="updown"><a href="/admin/reserve/sort/10/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/10/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>室数<span class="updown"><a href="/admin/reserve/sort/11/1" class="up"><--{Asset::img('ico_up01.png')}--></a><a href="/admin/reserve/sort/11/2" class="down"><--{Asset::img('ico_down01.png')}--></a></span></th>
<th>操作</th>
</tr>

<--{foreach from=$reserve item=item}-->
<tr <--{if ($item.RSV_STS == '9')}-->class="cancel"<--{/if}-->>
<--{if ($item.CHECK_FLG == '1')}-->
<td><input type='checkbox' name='check[]' value="<--{$item.HTL_ID}-->_<--{$item.RSV_NO}-->"></td>
<--{else if ($item.CHECK_FLG == '2')}-->
<td>済</td>
<--{else if ($item.CHECK_FLG == '9')}-->
<td>NS</td>
<--{else}-->
<td></td>
<--{/if}-->
<td><--{$item.HTL_NAME}--></td>
<td class="itemNum">stm<--{$item.RSV_NO}--><br><span>（<--{$item.RSV_DATE}-->）</span></td>
<td><--{$item.UP_DATE}--></span></td>
<td><--{$item.USR_NAME}--></td>
<td><--{$item.IN_DATE|date_format:"%Y-%m-%d"}--></td>
<td><--{$item.OUT_DATE|date_format:"%Y-%m-%d"}--></td>
<td><--{$item.NUM_STAY}--></td>
<td><--{$item.STATUS}--></td>
<td><--{$item.PLN_NAME}--></td>
<td><--{$item.TYPE_NAME}--></td>
<td><--{$item.ADJUST_TYPE_NAME}--></td>
<td><--{$item.PLN_CHG_TOTAL|number_format}-->円</td>
<td><--{$item.NUM_ROOM}--></td>
<td>
<div class="detail">
<input type="button" name="detail" value="詳細" onclick="location.href='/<--{$item.URL}-->'">
</div>
</td>
</tr>
<--{/foreach}-->

</table>
</div>

<div class="tableCheck tableCheckBottom clearfix">
<table class="planCheck">
<tr>
<td><input type="button" name="checkAll" value="全てをチェックする"></td>
<td><input type="button" name="removeAll" value="全てのチェックをはずす"></td>
<td>チェックした予約情報のステータスを変更
<div class="edit">
<input type="button" name="editAll">
<ul class="balloon">
<li><input type='submit' name='action' value='来店済'></li>
<!-- <li><input type='submit' name='action' value='キャンセルにする'></li> -->
<li><input type='submit' name='action' value='NS'></li>
</ul>
</div>
</td>
</tr>
<--{Form::close()}-->
</table>
</div>


<div class="tablePager clearfix">
<table class="pager">
<tr>
<--{Form::open("admin/reserve/page/`$first_page`")}-->
<td><input type="submit" name="first" value="" ></td>
<--{Form::close()}-->
<--{Form::open("admin/reserve/page/`$preview_page`")}-->
<td><input type="submit" name="prev" value="" ></td>
<--{Form::close()}-->
<--{Form::open("admin/reserve/page/`$next_page`")}-->
<td><--{$all_data_count}-->件中<--{$start_count}-->-<--{$rsv_data_count}-->件目</td>
<td><input type="submit" name="next" value="" ></td>
<--{Form::close()}-->
<--{Form::open("admin/reserve/page/`$last_page`")}-->
<td><input type="submit" name="last" value="" ></td>
<--{Form::close()}-->
<td><select name="limit" id="limit2" onChange="limit_change2()">
<option value="5"  <--{if ($limit_num == 5 )}-->selected<--{/if}--> >5</option>
<option value="10" <--{if ($limit_num == 10)}-->selected<--{/if}--> >10</option>
<option value="20" <--{if ($limit_num == 20)}-->selected<--{/if}--> >20</option>
</select>件ずつ表示</td>
</tr>
</table>
</div>
</div>
</div>
</div>
