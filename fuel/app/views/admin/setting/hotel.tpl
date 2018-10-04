
<!-- contents -->
<div id="contents">
<div class="inner">
<h2>施設情報設定</h2>
<p style="color: red;"><--{nl2br($error)}--></p>
<div class="edit otherEdit">
<p class="leadTxt">施設情報を変更される場合は、下記のフォームにご入力の上、「保存する」ボタンをクリックしてください。</p>
<--{Form::open('admin/setting/updatemailad')}-->
<table>
<tr>
<!-- <th>ホテル名</th>
<td><--{$HTL_NAME}--></td> -->
<th class="required">ホテル名</th>
<td class="email"><input type="text" name="hotel_name" value="<--{$HTL_NAME}-->"></td>
</tr>
<tr>
<th class="required">メールアドレス<br>（半角英数）</th>
<td class="email"><input type="text" name="email" id="email" value="<--{$HTL_MAIL}-->"></td>
</tr>
<tr>
<th class="required">住所</th>
<td class="email"><input type="text" name="address" id="address" value="<--{$HTL_ADR1}-->"></td>
</tr>
<tr>
<th class="required">電話番号</th>
<td class="email"><input type="text" name="tel" id="tel" value="<--{$HTL_TEL}-->"></td>
</tr>
<tr>
<th></th>
</tr>
<tr>
<th colspan="2">Ambassador Relations Tool 連携設定</th>
</tr>
<tr>
<th colspan="2"><input type="radio" name="art_link_flg" id="art_link_flg0" value="0"<--{if ($ART_LINK_FLG=='0')}--> checked<--{/if}-->><label for="art_link_flg0">連携しない</label>
<input type="radio" name="art_link_flg" id="art_link_flg1" value="1"<--{if ($ART_LINK_FLG=='1')}--> checked<--{/if}-->><label for="art_link_flg1">連携する</label></th>
</tr>
<tr class="artSetting" style="display:none">
<th class="required">アカウントキー</th>
<td class="email"><input type="text" name="art_account_key" id="art_account_key" value="<--{$ART_ACCOUNT_KEY}-->"></td>
</tr>
<tr class="artSetting" style="display:none">
<th class="required">シークレットキー</th>
<td class="email"><input type="text" name="art_account_secret" id="art_account_secret" value="<--{$ART_ACCOUNT_SECRET}-->"></td>
</tr>
</table>
<ul class="editBtn">
<li><input type="submit" name="update" value="保存する"></li>
</ul>
<--{Form::close()}-->
</div>
</div>
</div>
<!-- /contents -->