<!-- contents -->
<div id="contents">
<div class="inner">
<h2><?php echo $plan_data['PLN_NAME']; ?> – シークレットプラン一覧</h2>
<p style="color: red;"><?php echo $error; ?></p>
<div class="editTop">
<p class="leadTxt">登録内容のご確認および編集・削除をする場合は、該当する宿泊プランの「・・・」ボタンを押してください。<br>新たにシークレットプランを追加する場合は、一覧表の右上にございます「シークレットプランを追加する」ボタンを押してください。</p>
<div class="tablePager clearfix">
<table class="pager">
<tr>
<?php echo Form::open('admin/plan/page/'.$first_page);?>
<td><input type="submit" name="first" value=""></td>
</form>
<?php echo Form::open('admin/plan/page/'.$preview_page);?>
<td><input type="submit" name="prev" value=""></td>
</form>
<td><?php echo $all_data_count;?>件中<?php echo $start_count;?>-<?php echo $plan_data_count;?>件目</td>
<?php echo Form::open('admin/plan/page/'.$next_page);?>
<td><input type="submit" name="next" value=""></td>
</form>
<?php echo Form::open('admin/plan/page/'.$last_page);?>
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
<td><input type="button" name="add" value="プランを追加する" onclick="location.href = '/admin/plan/secret_new/<?php echo $plan_id; ?>';"></td>
</tr>
</table>
</div>
<div class="tableInner">
<table>
<tr>
<th class="sort">表示順<span class="updown"><a href="javascript:void(0);" class="up"><img src="/assets/img/ico_up01.png" alt=""></a><a href="javascript:void(0);" class="down"><img src="/assets/img/ico_down01.png" alt=""></a></span></th>
<th>宿泊プランID<span class="updown"><a href="javascript:void(0);" class="up"><img src="/assets/img/ico_up01.png" alt=""></a><a href="javascript:void(0);" class="down"><img src="/assets/img/ico_down01.png" alt=""></a></span></th>
<th>宿泊プラン名<span class="updown"><a href="javascript:void(0);" class="up"><img src="/assets/img/ico_up01.png" alt=""></a><a href="javascript:void(0);" class="down"><img src="/assets/img/ico_down01.png" alt=""></a></span></th>
<th>URL<span class="updown"></span></th>
<th class="lang">販売言語<span class="updown"><a href="javascript:void(0);" class="up"><img src="/assets/img/ico_up01.png" alt=""></a><a href="javascript:void(0);" class="down"><img src="/assets/img/ico_down01.png" alt=""></a></span></th>
<th class="status">販売状態</th>
<th class="edit">操作</th>
</tr>
<?php 
    foreach ($plans as $key => $plan) {
      $i = $key +1;
      if ($i < 10) {
        $i = '0'.$i;
      }

      if ($plan['PLN_USE_FLG'] == 0) {
        $stop_flg = 'checked';    $sale_flg = '';
      }else{
        $stop_flg = '';           $sale_flg = 'checked';
      }

      echo "<tr>";
      echo "<td><input type='checkbox' name='check[]' value='".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].EXPLODE.$plan['SECRET_ID']."'><input type='number' class='sale_flg' htl_pln_id=".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].EXPLODE.$plan['SECRET_ID']." min='1' max='10' value='".$plan['SORT_NUM']."'></td>";
      echo "<td>".$plan['PLN_ID'].'S'.$plan['SECRET_ID']."</td>";
      echo "<td>".$plan['PLN_NAME']."</td>";
      echo "<td>".'/secret/'.$plan['PLN_ID'].'_'.$plan['SECRET_ID']."</td>";
      echo "<td>";
      echo "<ul class='lang'>";
      echo "<li class='active'>".Asset::img('ico_lang01_jp.png',array('alt' => ''))."</li>";
          echo "<li></li>";
          echo "<li></li>";
          echo "<li></li>";
          echo "<li></li>";
      echo "</ul>";
      echo "</td>";
      echo "<td class='status'>";
      echo "<ul class='clearfix'>";
      echo "<li><input type='radio' name='saleStatus".$i."' id='saleStatus".$i."01' ".$stop_flg."><label for='saleStatus".$i."01' class='stop' htl_pln_id=".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].EXPLODE.$plan['SECRET_ID'].">停止</label></li>";
      echo "<li><input type='radio' name='saleStatus".$i."' id='saleStatus".$i."02' ".$sale_flg."><label for='saleStatus".$i."02' class='onsale' htl_pln_id=".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].EXPLODE.$plan['SECRET_ID'].">販売</label></li>";
      echo "</ul>";
      echo "</td>";
      echo "<td>";
      echo "<div class='edit'>";
      echo "<input type='button' name='edit'>";
      echo "<ul class='balloon'>";
      echo "<li><a>".Html::anchor('admin/plan/secret_edit/'.$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].EXPLODE.$plan['SECRET_ID'] ,'編集する')."</a></li>";
      echo "<li><a>".Html::anchor('admin/plan/secret_delete/'.$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].EXPLODE.$plan['SECRET_ID'] ,'削除する')."</a></li>";
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
<?php echo Form::open('admin/plan/page/'.$first_page);?>
<td><input type="submit" name="first" value=""></td>
</form>
<?php echo Form::open('admin/plan/page/'.$preview_page);?>
<td><input type="submit" name="prev" value=""></td>
</form>
<td><?php echo $all_data_count;?>件中<?php echo $start_count;?>-<?php echo $plan_data_count;?>件目</td>
<?php echo Form::open('admin/plan/page/'.$next_page);?>
<td><input type="submit" name="next" value=""></td>
</form>
<?php echo Form::open('admin/plan/page/'.$last_page);?>
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
