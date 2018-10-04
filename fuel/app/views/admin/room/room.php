
<!-- contents -->
<div id="contents">
<div class="inner">
<h2>部屋タイプ</h2>
<p style="color: red;"><?php echo $error; ?></p>
<div class="editTop">
<p class="leadTxt">登録内容のご確認及び編集・削除をする場合は、該当するカテゴリの「編集」ボタンを押してください。<br>新たに部屋タイプを追加する場合は、一覧表の右上にございます「部屋タイプを追加する」ボタンを押してください。<br><span class="note">※部屋タイプは宿泊プランの作成・編集時に使用します。</span></p>
<div class="tablePager clearfix">
<table class="pager">
<tr>
<?php echo Form::open('admin/room/page/'.$first_page);?>
<td><input type="submit" name="first" value=""></td>
</form>
<?php echo Form::open('admin/room/page/'.$preview_page);?>
<td><input type="submit" name="prev" value=""></td>
</form>
<td><?php echo $all_data_count;?>件中<?php echo $start_count;?>-<?php echo $room_data_count;?>件目</td>
<?php echo Form::open('admin/room/page/'.$next_page);?>
<td><input type="submit" name="next" value=""></td>
</form>
<?php echo Form::open('admin/room/page/'.$last_page);?>
<td><input type="submit" name="last" value=""></td>
</form>
<td><select name="limit" id="limit" onChange="limit_change()">
<option value="5"  <?php if($limit_num == 5){echo "selected";}?> >5</option>
<option value="10" <?php if($limit_num == 10){echo "selected";}?> >10</option>
<option value="20" <?php if($limit_num == 20){echo "selected";}?> >20</option>
</select>件ずつ表示</td>
</tr>
</table>
<table class="planEdit">
<tr>
<td><input type="button" name="add" value="部屋タイプを追加する" onclick="new_room()"></td>
</tr>
</table>
</div>
<div class="tableInner">
<table>
<tr>
<th class="sort">表示順<span class="updown"><a href="<?php echo HTTP.'/admin/room/sort/st0/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/room/sort/st0/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>部屋タイプID<span class="updown"><a href="<?php echo HTTP.'/admin/room/sort/st1/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/room/sort/st1/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>部屋タイプ名<span class="updown"><a href="<?php echo HTTP.'/admin/room/sort/st2/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/room/sort/st2/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>収容人数<span class="updown"><a href="<?php echo HTTP.'/admin/room/sort/st3/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/room/sort/st3/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>総提供室数<span class="updown"><a href="<?php echo HTTP.'/admin/room/sort/st4/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/room/sort/st4/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th class="status">利用可否</th>
<th class="edit">編集</th>
</tr>

<!--foreach-->
<?php 
    foreach ($rooms as $key => $room) {
      $i = $key +1;
      if ($i < 10) {
        $i = '0'.$i;
      }

      if ($room['RM_USE_FLG'] == 0) {
        $stop_flg = 'checked';    $sale_flg = '';
      }else{
        $stop_flg = '';           $sale_flg = 'checked';
      }

      echo "<tr>";
      echo "<td><input type='number'  class='sale_flg' htl_type_id=".$room['HTL_ID'].EXPLODE.$room['TYPE_ID']." min='1' max='10' value='".$room['DISP_ORDER']."'></td>";
      echo "<td>".$room['TYPE_ID']."</td>";
      echo "<td>".$room['TYPE_NAME']."</td>";
      echo "<td>".$room['CAP_MIN']."～".$room['CAP_MAX']."</td>";
      echo "<td>".$room['RM_NUM']."室</td>";
      echo "<td class='status'>";
      echo "<ul class='clearfix'>";
      echo "<li><input type='radio' name='saleStatus".$i."' id='saleStatus".$i."01' ".$stop_flg."><label for='saleStatus".$i."01' class='stop' htl_type_id=".$room['HTL_ID'].EXPLODE.$room['TYPE_ID'].">停止</label></li>";
      echo "<li><input type='radio' name='saleStatus".$i."' id='saleStatus".$i."02' ".$sale_flg."><label for='saleStatus".$i."02' class='onsale' htl_type_id=".$room['HTL_ID'].EXPLODE.$room['TYPE_ID'].">販売</label></li>";
      echo "</ul>";
      echo "</td>";
      echo "<td>";
      echo "<div class='edit'>";
      echo "<input type='button' name='edit'>";
      echo "<ul class='balloon'>";
      echo "<li><a>".Html::anchor('admin/room/edit/'.$room['HTL_ID'].EXPLODE.$room['TYPE_ID'] ,'編集する')."</a></li>";
      echo "<li><a>".Html::anchor('admin/room/delete/'.$room['HTL_ID'].EXPLODE.$room['TYPE_ID'] ,'削除する')."</a></li>";
      echo "</ul>";
      echo "</div>";
      echo "</td>";
      echo "</tr>";

    }

?>

</table>
</div>
<div class="tablePager clearfix">
<table class="pager">
<tr>
<?php echo Form::open('admin/room/page/'.$first_page);?>
<td><input type="submit" name="first" value=""></td>
</form>
<?php echo Form::open('admin/room/page/'.$preview_page);?>
<td><input type="submit" name="prev" value=""></td>
</form>
<td><?php echo $all_data_count;?>件中<?php echo $start_count;?>-<?php echo $room_data_count;?>件目</td>
<?php echo Form::open('admin/room/page/'.$next_page);?>
<td><input type="submit" name="next" value=""></td>
</form>
<?php echo Form::open('admin/room/page/'.$last_page);?>
<td><input type="submit" name="last" value=""></td>
</form>
<td><select name="limit" id="limit2" onChange="limit_change2()">
<option value="5"  <?php if($limit_num == 5){echo "selected";}?> >5</option>
<option value="10" <?php if($limit_num == 10){echo "selected";}?> >10</option>
<option value="20" <?php if($limit_num == 20){echo "selected";}?> >20</option>
</select>件ずつ表示</td>
</tr>
</table>
</div>
</div>
</div>
</div>
<!-- /contents -->
