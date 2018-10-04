<!-- contents -->
<div id="contents">
<div class="inner">
<h2>部屋タイプの編集</h2>
<p style="color: red;"><?php echo $error;?></p>
<div class="edit roomEdit">
<?php echo Form::open(array('action' => 'admin/room/'.$action, 'enctype' => 'multipart/form-data'));?>
<div class="subSection">
<div class="tableBox">
<table>
<tr>
<th>部屋プランID</th>
<td><?php echo $type_id;?><input type="hidden" name="HtlTypeID" id='HtlTypeID' value="<?php echo $htl_id.EXPLODE.$type_id;?>"></td>
</tr>
<tr>
<th class="required">部屋タイプ名</th>
<td class="name">
<ul>
<li><input type="text" name="roomNameJP" id="roomName01" value="<?php echo $room['TYPE_NAME'];?>"></li>
<li><span>英語表記</span><input type="text" name="roomNameEN" id="roomName02" value="<?php echo $room['TYPE_NAME_EN'];?>"></li>
<li><span>繁体字表記</span><input type="text" name="roomNameCHH" id="roomName03" value="<?php echo $room['TYPE_NAME_CHH'];?>"></li>
<li><span>簡体字表記</span><input type="text" name="roomNameCH" id="roomName04" value="<?php echo $room['TYPE_NAME_CH'];?>"></li>
<li><span>韓国語表記</span><input type="text" name="roomNameKO" id="roomName05" value="<?php echo $room['TYPE_NAME_KO'];?>"></li>
</ul>
</td>
</tr>
<tr>
<th class="required">総提供室数</th>
<td class="number">
<p><input type="text" name="roomNumber" id="roomNumber" value="<?php echo $room['RM_NUM'];?>">室<span>（※半角のみ）</span></p>
<p class="note">※全プランとおして提供できる室数をご入力ください。<br>日によって提供室数を調整する場合は「在庫管理」から設定頂けます</p>
</td>
</tr>
<tr>
<th class="required">収容人数</th>
<td class="range">
<ul class="clearfix">
<li><select name="capacityNumLower" id="capacityNum01">
  <option value="1" <?php if( $room['CAP_MIN'] == '1' ){echo "selected";} ?> >1</option>
  <option value="2" <?php if( $room['CAP_MIN'] == '2' ){echo "selected";} ?> >2</option>
  <option value="3" <?php if( $room['CAP_MIN'] == '3' ){echo "selected";} ?> >3</option>
  <option value="4" <?php if( $room['CAP_MIN'] == '4' ){echo "selected";} ?> >4</option>
  <option value="5" <?php if( $room['CAP_MIN'] == '5' ){echo "selected";} ?> >5</option>
  <option value="6" <?php if( $room['CAP_MIN'] == '6' ){echo "selected";} ?> >6</option>
</select>名</li>
<li><span>～</span></li>
<li><select name="capacityNumUpper" id="capacityNum02">
  <option value="1" <?php if( $room['CAP_MAX'] == '1' ){echo "selected";} ?> >1</option>
  <option value="2" <?php if( $room['CAP_MAX'] == '2' ){echo "selected";} ?> >2</option>
  <option value="3" <?php if( $room['CAP_MAX'] == '3' ){echo "selected";} ?> >3</option>
  <option value="4" <?php if( $room['CAP_MAX'] == '4' ){echo "selected";} ?> >4</option>
  <option value="5" <?php if( $room['CAP_MAX'] == '5' ){echo "selected";} ?> >5</option>
  <option value="6" <?php if( $room['CAP_MAX'] == '6' ){echo "selected";} ?> >6</option>
</select>名</li>
</ul>
</td>
</tr>
<tr>
<th>利用可否</th>
<td class="select">
<ul class="clearfix">
<li><input type="radio" name="use" id="use01" <?php echo $use_flg;?> value="1"><label for="use01">利用する</label></li>
<li><input type="radio" name="use" id="use02" <?php echo $unuse_flg;?> value="0"><label for="use02">利用しない</label></li>
</ul>
</td>
</tr>
<th>性別</th>
<td class="select">
<ul class="clearfix">
<li><input type="radio" name="gender" id="gender02" <?php echo $man_flg;?> value="1"><label for="gender02">男性用</label></li>
<li><input type="radio" name="gender" id="gender03" <?php echo $woman_flg;?> value="2"><label for="gender03">女性用</label></li>
<li><input type="radio" name="gender" id="gender01" <?php echo $both_flg;?> value="0"><label for="gender01">指定なし</label></li>
</ul>
</td>
</tr>
<tr>
<th>禁煙喫煙区分</th>
<td class="select">
<ul class="clearfix">
<li><input type="radio" name="smoke" id="smoke01" <?php echo $unsmoke_flg;?> value="1" ><label for="smoke01">禁煙</label></li>
<li><input type="radio" name="smoke" id="smoke02" <?php echo $smoke_flg;?> value="0" ><label for="smoke02">喫煙</label></li>
</ul>
</td>
</tr>
<tr>
<th>部屋画像<br>推奨サイズ<br>ヨコ657px<br>タテ444px</th>
<td class="number">

<p style="position: relative; top: 5px;"><label class="manageImg">画像を管理<input type="file" name="picFile1" class="uploadHtlImg" style="display: none;"></label></p><?php echo Asset::img($img1,array('height' => '100')) ?>
</td>

</tr>
</table>
<ul class="editBtn">
<?php if($type_id != '新規'){echo "<li><input type='button' name='delete' value='削除する' onclick='delete_room()'></li>";} ?>
<li><input type="submit" name="update" value="更新する"></li>
</ul>
</div>
</div><!-- /subSection -->
<?php echo Form::close();?>
</div>
</div>
</div>
<!-- /contents -->
