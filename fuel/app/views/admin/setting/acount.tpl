<div id="contents">
<div class="inner">
<h2>アカウント設定</h2>
<h3 style="color: red;"><--{$error}--></h3>
<div class="edit otherEdit">
<p class="leadTxt">設定を変更される場合は、下記のフォームにご入力の上「保存する」ボタンをクリックしてください。<br><span style="color:#c33;">※サイトコントローラーと連動している場合、パスワードを変更すると連動ができなくなりますのでご注意ください。</span></p>
<!-- <form action="" method="post"> -->
<--{form::open('admin/setting/password')}-->
<table>
<tr>
<th>ID</th>
<td><--{$ID}--></td>
</tr>
<tr>
<th class="required">パスワード<br>（半角英数）</th>
<td class="password"><input type="password" name="loginPass" id="loginPass"></td>
</tr>
</table>
<ul class="editBtn">
<li><input type="submit" name="update" value="保存する"></li>
</ul>
<--{form::close()}-->
<!-- </form> -->
</div>
</div>
</div>

