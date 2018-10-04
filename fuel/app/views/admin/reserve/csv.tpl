<div id="contents">
<div class="inner">
<h2>予約CSV出力</h2>
<p style="color: red"><--{$error}--></p>
<div class="edit otherEdit">
<p class="leadTxt">出力条件を設定し「CSV出力」ボタンをクリックすると、条件に沿ったCSVファイルがダウンロードできます。<br>※起算日が「チェックイン日」の場合は、取得期間終了日が未来の日付でも出力可能です。<br>※販売期間は最大で1ヶ月間まで指定可能です。</p>
<form action="" method="post">
<table>
<tr>
<th class="required">販売期間</th>
<td class="term">
<ul class="clearfix">
<li><input type="text" name="csvTerm" id="csvTerm01"><label for="csvTerm01"></label></li>
<li><span>～</span></li>
<li><input type="text" name="csvTerm" id="csvTerm02"><label for="csvTerm02"></label></li>
</ul>
</td>
</tr>
<tr>
<th class="required">起算日</th>
<td class="reckon">
<ul class="clearfix">
<li><input type="radio" name="reckon" id="reckon01" value="1" checked=""><label for="reckon01">予約日</label></li>
<li><input type="radio" name="reckon" id="reckon02" value="2" ><label for="reckon02">チェックイン日</label></li>
</ul>
</td>
</tr>
</table>
<ul class="editBtn">
<li><input type="button" onclick="get_csv('<--{$htl_id}-->');" name="output" value="CSV出力する"></li>
</ul>
</form>
</div>
</div>
</div>