
<!-- contents -->
<div id="contents">
<div class="inner">
<h2>通知メール設定</h2>
<p style="color: red;"><--{$error}--></p>
<div class="edit mailEdit">
<--{Form::open('admin/setting/updatemailtemp')}-->
<div class="editBox">
<div class="editTab clearfix">
<ul>
<li><a href="javascript:void(0);"><span>予約完了メール</span></a></li>
<li><a href="javascript:void(0);"><span>予約変更メール</span></a></li>
<li style="display:none;"><a href="javascript:void(0);"><span>事前確認メール</span></a></li>
<li style="display:none;"><a href="javascript:void(0);"><span>サンクスメール</span></a></li>
<li><a href="javascript:void(0);"><span>キャンセルメール</span></a></li>
<li class="row2"><a href="javascript:void(0);"><span>管理画面<br>キャンセルメール</span></a></li>
</ul>
</div>
<div class="editInner">
<div class="section">
<h3>予約完了メール</h3>
<p class="leadTxt">予約申込みの際に自動で送信されるメールです。<br><span class="note">※本文には差込が利用できます。</span></p>
<table>
<tr>
<th>メール件名<br>(施設様宛)</th>
<td class="address"><input type="text" name="address_cfm" id="address01" value="<--{$HTL.MAIL_CFM_TITLE}-->"></td>
</tr>
<tr>
<th>メール件名</th>
<td class="mailTtl address">
<p><input type="text" value="予約完了メール" readonly></p>
<p class="attention">※変更できません</p>
<p class="note">※差込可能 <span>[受付日]  [キャンセル日]  [ホテル名]  [予約番号]  [チェックイン予定日]  [チェックイン時刻]  [チェックアウト予定日]  [プラン名]  [部屋タイプ名]  [プラン内容]  [人数]  [子供人数]  [室数]  [泊数]  [チェックイン]  [宿泊者名]  [料金]  [支払い方法]  [キャンセルポリシー]  [施設メールアドレス]</span></p></td>
</tr>
<tr>
<th>メール本文</th>
<td class="mailTxt"><textarea name="mailTxt_cfm"><--{$HTL.MAIL_CFM}--></textarea></tr>
</table>
</div><!-- /section -->
<div class="section">
<h3>予約変更メール</h3>
<p class="leadTxt">予約変更の際に自動で送信されるメールです。<br><span class="note">※本文には差込が利用できます。</span></p>
<table>
<tr>
<th>メール件名<br>(施設様宛)</th>
<td class="address"><input type="text" name="address_chg" id="address01" value="<--{$HTL.MAIL_CHG_TITLE}-->"></td>
</tr>
<tr>
<th>メール件名</th>
<td class="mailTtl address">
<p><input type="text" value="予約変更メール" readonly></p>
<p class="attention">※変更できません</p>
<p class="note">※差込可能 <span>[受付日]  [キャンセル日]  [ホテル名]  [予約番号]  [チェックイン予定日]  [チェックイン時刻]  [チェックアウト予定日]  [プラン名]  [部屋タイプ名]  [プラン内容]  [人数]  [子供人数]  [室数]  [泊数]  [チェックイン]  [宿泊者名]  [料金]  [支払い方法]  [キャンセルポリシー]  [施設メールアドレス]</span></p></td>
</tr>
<tr>
<th>メール本文</th>
<td class="mailTxt"><textarea name="mailTxt_chg"><--{$HTL.MAIL_CHG}--></textarea></tr>
</table>
</div><!-- /section -->
<div class="section">
<h3>事前確認メール</h3>
<p class="leadTxt">予約申込みの際に自動で送信されるメールです。<br><span class="note">※本文には差込が利用できます。</span></p>
<table>
<tr>
<th>メール件名<br>(施設様宛)</th>
<td class="address"><input type="text" name="address_bfr" id="address01" value="<--{$HTL.MAIL_BFR_TITLE}-->"></td>
</tr>
<tr>
<th>メール件名</th>
<td class="mailTtl address">
<p><input type="text" value="事前確認メール" readonly></p>
<p class="attention">※変更できません</p>
<p class="note">※差込可能 <span>[受付日]  [キャンセル日]  [ホテル名]  [予約番号]  [チェックイン予定日]  [チェックイン時刻]  [チェックアウト予定日]  [プラン名]  [部屋タイプ名]  [プラン内容]  [人数]  [子供人数]  [室数]  [泊数]  [チェックイン]  [宿泊者名]  [料金]  [支払い方法]  [キャンセルポリシー]  [施設メールアドレス]</span></p></td>
</tr>
<tr>
<th>メール本文</th>
<td class="mailTxt"><textarea name="mailTxt_bfr"><--{$HTL.MAIL_BFR}--></textarea></tr>
</table>
</div><!-- /section -->
<div class="section">
<h3>サンクスメール</h3>
<p class="leadTxt">予約申込みの際に自動で送信されるメールです。<br><span class="note">※本文には差込が利用できます。</span></p>
<table>
<tr>
<th>メール件名<br>(施設様宛)</th>
<td class="address"><input type="text" name="address_thk" id="address01" value="<--{$HTL.MAIL_THK_TITLE}-->"></td>
</tr>
<tr>
<th>メール件名</th>
<td class="mailTtl address">
<p><input type="text" value="サンクスメール" readonly></p>
<p class="attention">※変更できません</p>
<p class="note">※差込可能 <span>[受付日]  [キャンセル日]  [ホテル名]  [予約番号]  [チェックイン予定日]  [チェックイン時刻]  [チェックアウト予定日]  [プラン名]  [部屋タイプ名]  [プラン内容]  [人数]  [子供人数]  [室数]  [泊数]  [チェックイン]  [宿泊者名]  [料金]  [支払い方法]  [キャンセルポリシー]  [施設メールアドレス]</span></p></td>
</tr>
<tr>
<th>メール本文</th>
<td class="mailTxt"><textarea name="mailTxt_thk"><--{$HTL.MAIL_THK}--></textarea></tr>
</table>
</div><!-- /section -->
<div class="section">
<h3>キャンセルメール</h3>
<p class="leadTxt">予約キャンセルの際に自動で送信されるメールです。<br><span class="note">※本文には差込が利用できます。</span></p>
<table>
<tr>
<th>メール件名<br>(施設様宛)</th>
<td class="address"><input type="text" name="address_ccl" id="address01" value="<--{$HTL.MAIL_CCL_TITLE}-->"></td>
</tr>
<tr>
<th>メール件名</th>
<td class="mailTtl address">
<p><input type="text" value="予約キャンセルメール" readonly></p>
<p class="attention">※変更できません</p>
<p class="note">※差込可能 <span>[受付日]  [キャンセル日]  [ホテル名]  [予約番号]  [チェックイン予定日]  [チェックイン時刻]  [チェックアウト予定日]  [プラン名]  [部屋タイプ名]  [プラン内容]  [人数]  [子供人数]  [室数]  [泊数]  [チェックイン]  [宿泊者名]  [料金]  [支払い方法]  [キャンセルポリシー]  [施設メールアドレス]</span></p></td>
</tr>
<tr>
<th>メール本文</th>
<td class="mailTxt"><textarea name="mailTxt_ccl"><--{$HTL.MAIL_CCL}--></textarea></tr>
</table>
</div><!-- /section -->
<div class="section">
<h3>管理画面キャンセルメール</h3>
<p class="leadTxt">管理画面より予約キャンセルした際に自動で送信されるメールです。<br><span class="note">※本文には差込が利用できます。</span></p>
<table>
<tr>
<th>メール件名<br>(施設様宛)</th>
<td class="address"><input type="text" name="address_adccl" id="address01" value="<--{$HTL.MAIL_ADCCL_TITLE}-->"></td>
</tr>
<tr>
<th>メール件名</th>
<td class="mailTtl address">
<p><input type="text" value="予約キャンセルメール" readonly></p>
<p class="attention">※変更できません</p>
<p class="note">※差込可能 <span>[受付日]  [キャンセル日]  [ホテル名]  [予約番号]  [チェックイン予定日]  [チェックイン時刻]  [チェックアウト予定日]  [プラン名]  [部屋タイプ名]  [プラン内容]  [人数]  [子供人数]  [室数]  [泊数]  [チェックイン]  [宿泊者名]  [料金]  [支払い方法]  [キャンセルポリシー]  [施設メールアドレス]</span></p></td>
</tr>
<tr>
<th>メール本文</th>
<td class="mailTxt"><textarea name="mailTxt_adccl"><--{$HTL.MAIL_ADCCL}--></textarea></tr>
</table>
</div><!-- /section -->
</div>
</div>
<ul class="editBtn">
<li><input type="submit" name="update" value="更新する"></li>
</ul>
<--{Form::close()}-->
</div>
</div>
</div>
<!-- /contents -->