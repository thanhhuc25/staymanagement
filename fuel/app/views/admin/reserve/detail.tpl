<!-- contents -->
<div id="contents">
<div class="inner">
<h2>予約管理</h2>
<div class="editTop reserveEditTop">
<div class="detailTop">
<h3>予約情報</h3>
<ul class="searchList clearfix">
<li class="col3"><dl>
<dt>予約番号：</dt>
<dd>stm<--{$rsv.RSV_NO}--></dd>
</dl></li>
<li class="col2"><dl>
<dt>状況：</dt>
<dd><--{if ($rsv.RSV_STS == 0)}-->仮予約<--{else if ($rsv.RSV_STS == 1)}-->予約確定<--{else if ($rsv.RSV_STS == 9)}-->キャンセル<--{else}-->エラー<--{/if}--></dd>
</dl></li>
<li class="col3"><dl>
<dt>プラン名：</dt>
<dd><--{$rsv.PLN_NAME}--></dd>
</dl></li>
<li class="col3"><dl>
<dt>宿泊期間：</dt>
<dd class="term"><ul class="clearfix">
<li><--{$rsv.in_date}--></li>
<li><span>～</span></li>
<li><--{$rsv.out_date}--></li>
</ul></dd>
</dl></li>
<li class="col3"><dl>
<dt>チェックイン予定：</dt>
<dd><--{$rsv.IN_DATE_TIME}--></dd>
</dl></li>
<li class="col3"><dl>
<dt>プラン合計料金：</dt>
<dd><--{$rsv.PLN_CHG_TOTAL|number_format}-->円</dd>
</dl></li>
<li class="col2"><dl>
<dt>お支払方法：</dt>
<dd><--{if ($rsv.ADJUST_TYPE == 1)}-->フロント清算<--{else if ($rsv.ADJUST_TYPE == 2)}-->カード精算<--{else}-->エラー<--{/if}--></dd>
</dl></li>
<li><dl>
<dt>予約申込日時：</dt>
<dd><--{$rsv.rsv_date}--></dd>
</dl></li>
<li><dl>
<dt>備考：</dt>
<dd><--{$rsv.MEMO}--></dd>
</dl></li>
</ul>
<div class="tableDetail">
<h4>ゲスト</h4>
<table class="guest">
<--{foreach from=$rsv_detail item=item}-->
<tr>
<th>SEQ</th>
<td><--{$item.SEQ_ROOM}--></td>
</tr>
<tr>
<th>お部屋</th>
<td><--{$item.TYPE_NAME}--></td>
</tr>
<tr>
<th>お名前</th>
<td><--{$item.USR_NAME}--></td>
</tr>
<--{/foreach}-->
</table>

</div>
<ul class="editBtn">
<--{if ($rsv.RSV_STS != 9)}-->
<--{if ($rsv.COME_FLG == 0)}-->
<li><input type="button" name="mailsend" value="予約完了メール再送信" onclick="resend('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->');" ></li>
<!-- <li><input type="button" name="change" value="予約変更"></li> -->
<--{/if}-->
<li><input type="button" name="cancel" value="予約キャンセル" onclick="cancel('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->');"></li>
<--{/if}-->

<--{if ($changeable)}-->
<--{if ($rsv.COME_FLG != 0)}-->
<li><input type="button" name="cancel" value="来店状況を削除" onclick="chgcomeflg('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->_1');" ></li>
<--{/if}-->
<--{if ($rsv.COME_FLG != 1)}-->
<li><input type="button" name="update2" value="来店済みにする" onclick="chgcomeflg('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->_2');" ></li>
<--{/if}-->
<--{if ($rsv.COME_FLG != 9)}-->
<li><input type="button" name="update2" value="NO SHOWにする" onclick="chgcomeflg('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->_3');" ></li>
<--{/if}-->
<--{/if}-->
</ul>
<!-- <br> -->
<!-- 
<ul class="editBtn ">
<li><span style="font-size: 16px;">この予約は来店済みです。</span></li>
<li></li>
<li></li>
<li></li>
<li></li>
<li></li>
<--{if ($rsv.COME_FLG != 0)}-->
<li><input type="button" name="cancel" value="来店状況を削除" onclick="chgcomeflg('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->_1');" ></li>
<--{/if}-->
<--{if ($rsv.COME_FLG != 1)}-->
<li><input type="button" name="update2" value="来店済みにする" onclick="chgcomeflg('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->_2');" ></li>
<--{/if}-->
<--{if ($rsv.COME_FLG != 9)}-->
<li><input type="button" name="update2" value="NO SHOWにする" onclick="chgcomeflg('<--{$rsv.HTL_ID}-->_<--{$rsv.RSV_NO}-->_3');" ></li>
<--{/if}-->
</ul> -->
</div>
<div class="detailTop">
<h3>お客さま情報</h3>
<ul class="searchList clearfix">
<li class="col3"><dl>
<dt>お名前：</dt>
<dd><--{$rsv.USR_NAME}--></dd>
</dl></li>
<li class="col2"><dl>
<dt>フリガナ：</dt>
<dd><--{$rsv.USR_KANA}--></dd>
</dl></li>
<li class="col3"><dl>
<dt>連絡先お電話番号：</dt>
<dd><--{$rsv.USR_TEL}--></dd>
</dl></li>
<li class="col2"><dl>
<dt>FAX：</dt>
<dd><--{$rsv.USR_FAX}--></dd>
</dl></li>
<li><dl>
<dt>ご住所：</dt>
<dd><--{$rsv.USR_ADR1}--><--{$rsv.USR_ADR2}--></dd>
</dl></li>
<li><dl>
<dt>メールアドレス：</dt>
<dd><--{$rsv.USR_MAIL}--></dd>
</dl></li>
<li><dl>
<dt>領収書名：</dt>
<dd></dd>
</dl></li>
</ul>
<!--ul class="editBtn">
<li><input type="button" name="edit" value="基本情報編集"></li>
</ul-->
</div>
<div class="detailTop">
<h3>料金明細</h3>
<div class="tableDetail">
<h4>部屋料金</h4>
<table>
<tr>
<th colspan="3">項　目</th>
<th>単　価</th>
<th>人数・数量</th>
</tr>
<--{foreach from=$payment key=key item=item}-->
<tr>
<td rowspan="2"><--{$key}--></td>
<td rowspan="2"><--{$item.TYPE_NAME}--></td>
<td class="gender">大人（男性）</td>
<--{if ($item.PLN_NUM_MAN > 0)}-->
<td><--{$item.PAYMENT|number_format}-->円</td>
<td><--{$item.PLN_NUM_MAN}-->/<--{$item.RM_NUM}--></td>
<--{else}-->
<td>0円</td>
<td>0/0</td>
<--{/if}-->
</tr>
<tr>
<td class="gender">大人（女性）</td>
<--{if ($item.PLN_NUM_WOMAN > 0)}-->
<td><--{$item.PAYMENT|number_format}-->円</td>
<td><--{$item.PLN_NUM_WOMAN}-->/<--{$item.RM_NUM}--></td>
<--{else}-->
<td>0円</td>
<td>0/0</td>
<--{/if}-->
</tr>
<--{/foreach}-->
</table>
</div>
<!-- <div class="tableDetail">
<h4>オプション料金</h4>
<table>
<tr>
<th>項　目</th>
<th>課金対象</th>
<th>単　価</th>
<th>人数・数量</th>
</tr>
<tr>
<td>○○○○○○○○○○</td>
<td>○○○○○○○○</td>
<td>00,000円</td>
<td>0/0</td>
</tr>
</table>
</div> -->
</div>
</div>
</div>
</div>
