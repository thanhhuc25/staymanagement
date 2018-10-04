<!-- contents -->
<div id="contents">
<div class="inner">
<h2><?php echo $plan_data['PLN_NAME']; ?></h2>
<div class="edit planEdit">
<?php echo Form::open(array('action' => 'admin/plan/'.$action, 'enctype' => 'multipart/form-data'));?>
<input type="hidden" name="HtlPlnID" id="HtlPlnID" value="<?php echo $secret['HtlPlnID'];?>">
<div class="editBox">
<div class="editTab clearfix">
<ul>
<li><a href="javascript:void(0);"><span>基本設定</span></a></li>
</ul>
</div>
<div class="editInner">
<div class="section">
<table>
<tr>
<th>利用する</th>
<td>
<ul class="clearfix">
<li>
<input type="radio" name="PLN_USE_FLG" id="PLN_USE_FLG_0" value="0" <?php echo $secret['PLN_USE_FLG'] == 0 ? ' checked' : '';?>>
<label for="PLN_USE_FLG_0" class="stop">しない</label>　
</li>
<li>
<input type="radio" name="PLN_USE_FLG" id="PLN_USE_FLG_1" value="1" <?php echo $secret['PLN_USE_FLG'] ? ' checked' : '';?>>
<label for="PLN_USE_FLG_1" class="onsale">する</label>
</li>
</ul>
</td>
</tr>
<tr>
<th>カテゴリ</th>
<td class="name">
<input type="text" name="PLN_TYPE" id="PLN_TYPE" value="<?php echo $secret['PLN_TYPE'];?>">
</td>
</tr>
<tr>
<th>プラン名</th>
<td class="name">
<input type="text" name="PLN_NAME" id="PLN_NAME" value="<?php echo $secret['PLN_NAME'];?>">
</td>
</tr>
<tr>
<th>割引率</th>
<td class="rate">
<input type="number" step="0.1" min="0" max="100" name="PLN_RATE" id="PLN_RATE" value="<?php echo $secret['PLN_RATE']; ?>">%
</td>
</tr>
<tr>
<th>パスワード</th>
<td class="name">
<input type="text" name="PLN_PASS" id="PLN_PASS" value="<?php echo $secret['PLN_PASS']; ?>">
</td>
</tr>
<tr>
<th>その他特典</th>
<td class="name">
<textarea name="PLN_CAP_PC" id="PLN_CAP_PC"><?php echo $secret['PLN_CAP_PC'];?></textarea>
</td>
</tr>
</table>
</div><!-- /section -->
</div>
</div>
<ul class="editBtn">
<li><input type="button" name="delete" value="削除する" onclick="if (window.confirm('削除しますか？')) {location.href = '/admin/plan/secret_delete/'+$('#HtlPlnID').val();"></li>
<li><input type="submit" name="update" value="更新する"></li>
</ul>
</form>
</div>
</div>
</div>
<!-- /contents -->
