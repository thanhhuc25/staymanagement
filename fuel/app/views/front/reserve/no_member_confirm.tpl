<div id ="contents">

<div class="inner">
<div class="accountBox clearfix">
<--{FRONT_INC_LOGIN_MENU_HTML}-->
</div>
<section>
<h2>ご宿泊予約</h2>
<div class="reserveBox">
<ol class="formStep clearfix">
<li><span>ご宿泊予約内容・<br>決済方法の入力</span></li>
<li class="current"><span>入力内容の<br>ご確認</span></li>
<li><span>ご予約<br>完了</span></li>
</ol>
<div class="lead">
<p>入力内容をご確認の上、予約するボタンをクリックしてください。</p>
</div>
<div class="inputBox">
<--{Form::open(URL_RESERVE_ORDER)}-->
<dl>
<dt><span>ご予約内容</span></dt>
<dd>
<table>
<tr>
<th><span>お客様氏名</span></th>
<td><em><--{$post.name}--><--{$post.name2}--> 様</em></td>
</tr>
<tr>
<th><span>ご到着日</span></th>
<td><em><--{$plan.DATE}--></em></td>
</tr>
<tr>
<th><span>ご到着予定時刻</span></th>
<td><em><--{$plan.CHECK_IN}--></em></td>
</tr>
<tr>
<th><span>ご出発日</span></th>
<td><em>2017年00月00日</em></td>
</tr>
<tr>
<th><span>お部屋タイプ</span></th>
<td><em><--{$plan.TYPE_NAME}--></em></td>
</tr>
<tr>
<th><span>泊数</span></th>
<td><em><--{$plan.STAYDATENUM}-->泊</em></td>
</tr>
<tr>
<th><span>部屋数</span></th>
<td><em><--{$plan.STAYROOMNUM}-->部屋</em></td>
</tr>
<tr>
<th><span>ご宿泊者名カナ</span></th>
<td><em><--{$post.kana}--></em></td>
</tr>
<tr>
<th><span>E-mail</span></th>
<td><em><--{$post.email}--></em></td>
</tr>
</table>
</dd>
</dl>
<dl>
<dt><span>お客様情報</span></dt>
<dd>
<table>
<tr>
<th><span>氏名（姓）</span></th>
<td><--{$post.name}--></td>
</tr>
<tr>
<th><span>氏名（名）</span></th>
<td><--{$post.name2}--></td>
</tr>
<tr>
<th><span>氏名（フリガナ）</span></th>
<td><--{$post.kana}--></td>
</tr>
<tr>
<th><span>性別</span></th>
<td><--{if ($post.gender == 1)}-->男<--{else}-->女<--{/if}--></td>
</tr>
<tr>
<th><span>生年月日</span></th>
<td><--{$post.ciDate}--></td>
</tr>
<tr>
<th><span>E-mail(登録1)</span></th>
<td><--{$post.email}--></td>
</tr>
<tr>
<th><span>E-mail(登録2)</span></th>
<td><--{$post.email2}--></td>
</tr>
<tr>
<th><span>E-mail(登録3)</span></th>
<td><--{$post.email3}--></td>
</tr>
<tr>
<th><span>連絡先お電話番号</span></th>
<td><--{$post.tel}--></td>
</tr>
<tr>
<th><span>連絡先FAX番号</span></th>
<td><--{$post.fax}--></td>
</tr>
<tr>
<th><span>連絡先ご住所</span></th>
<td>
<p><span>郵便番号</span><--{$post.zipcode}--></p>
<p><span>都道府県市区町村</span><--{$post.address1}--></p>
<p><span>番地・建物名・号室</span><--{$post.address2}--></p>
</td>
</tr>
</table>
</dd>
<--{if (isset($sign_data))}-->
<dd>
<table>
<tr>
<th><span>メールマガジン</span></th>
<td><--{if ($sign_data.mailmagazin == 1)}-->希望する<--{else}-->希望しない<--{/if}--></td>
</tr>
<tr>
<th><span>パスワード</span></th>
<td><--{$password}--></td>
</tr>
<tr>
<th><span>パスワード（確認用）</span></th>
<td>xxxxxxxxxxxxxxxx</td>
</tr>
</table>
</dd>
<--{/if}-->
</dl>
<div class="reserveSpec">
<dl>
<dt><span>料金明細</span><span class="note">※料金はサービス料込・消費税込</span></dt>
<dd class="spec">
<table>
<tr>
<th class="spHide">ご宿泊日</th>
<th class="spHide">ご宿泊費</th>
<th class="spHide">オプション</th>
<th class="spHide">1室あたりの料金</th>
</tr>
<--{foreach from=$price key=k item=item}-->
<tr>
<td><span class="pcHide">ご宿泊日</span><--{$k}--></td>
<td><span class="pcHide">ご宿泊費</span><--{$item.one_person|number_format}-->円　×　<--{$ids.3}-->名</td>
<td><span class="pcHide">オプション</span>　--　</td>
<td><span class="pcHide">1室あたりの料金</span><--{$item.one_stay|number_format}-->円</td>
</tr>
<--{/foreach}-->
</table>
</dd>
<dd class="total">
<table>
<tr>
<th>合　計</th>
<td><--{$price_sum|number_format}-->円　×　<--{$ids.5}-->室　=　<--{$price_total|number_format}-->円</td>
</tr>
</table>
<p class="note">※料金はサービス料と消費税を含んでいます。</p>
</dd>
</dl>
</div>
<div class="policyTxt">
<p>※上記内容に間違いがなければ、予約確定ボタンをクリックしてください。</p>
</div>
<ul class="btn">
<li><input type="submit" value="以下に同意して予約する"></li>
<li class="back"><input type="button" value="戻　る"></li>
</ul>
<--{Form::close()}-->
</div>
</div>
<div class="policyTable">
<table>
<tr>
<th>キャンセルポリシー</th>
<td>
<p>キャンセル料について</p>
<p class="indent">キャンセル処理を行なった場合、以下のキャンセル料金を宿泊施設から請求いたします。<br>連絡なしの不泊/不着：宿泊料金の100％<br>当日：宿泊料金の80％<br>前日：宿泊料金の50％<br>3日前から：宿泊料金の30％</p>
</td>
</tr>
<tr>
<th>注意事項</th>
<td>
<p class="attention">チェックインが２３：００以降の場合は必ずご連絡ください。</p>
<p class="attention indent">※領収書は宿泊施設現地での発行となります。<br>詳細は宿泊施設まで直接お問い合わせください。 </p>
</td>
</tr>
</table>
</div>
</section>
</div>

</div>