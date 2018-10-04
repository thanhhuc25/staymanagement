<!-- contents -->
<div id="contents">
<div class="inner">
<h2><?php echo $title;?></h2>
<p style="color: red;"><?php echo $error; ?></p>
<div class="editTop">
<p class="leadTxt">登録内容のご確認および編集・削除をする場合は、該当する宿泊プランの「・・・」ボタンを押してください。<br>新たに宿泊プランを追加する場合は、一覧表の右上にございます「宿泊プランを追加する」ボタンを押してください。</p>
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
<form method="POST">
<table class="planEdit">
<tr>
<td class="status"><span><a href="<?php echo HTTP.'/admin/plan/showChange/1'?>" class="onsale">販売期間中</a><a href="<?php echo HTTP.'/admin/plan/showChange/2'?>" class="stop">販売終了済</a></span></td>
<td><input type="button" name="add" value="宿泊プランを追加する" onclick="new_plan()"></td>
</tr>
</table>
</div>
<div class="tableCheck tableCheckTop clearfix">
<table class="planCheck">
<tr>
<td><input type="button" name="checkAll" value="全てをチェックする"></td>
<td><input type="button" name="removeAll" value="全てのチェックをはずす"></td>
<td>チェックしたプランを
<div class="edit">
<input type="button" name="editAll">
<ul class="balloon">
<li><input type='submit' name='action' value='販売する'></li>
<li><input type='submit' name='action' value='停止する'></li>
<li><input type='submit' name='action' value='削除する'></li>
</ul>
</div>
</td>
</tr>
</table>
</div>
<div class="tableInner">
<table>
<tr>
<th class="sort">表示順<span class="updown"><a href="<?php echo HTTP.'/admin/plan/sort/st0/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/plan/sort/st0/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>宿泊プランID<span class="updown"><a href="<?php echo HTTP.'/admin/plan/sort/st1/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/plan/sort/st1/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>宿泊プラン名<span class="updown"><a href="<?php echo HTTP.'/admin/plan/sort/st2/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/plan/sort/st2/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th>販売期間<span class="updown"><a href="<?php echo HTTP.'/admin/plan/sort/st3/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/plan/sort/st3/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th class="lang">販売言語<span class="updown"><a href="<?php echo HTTP.'/admin/plan/sort/st4/1'?>" class="up"><?php echo Asset::img('ico_up01.png',array('alt' => '')) ?></a><a href="<?php echo HTTP.'/admin/plan/sort/st4/2'?>" class="down"><?php echo Asset::img('ico_down01.png',array('alt' => '')) ?></a></span></th>
<th class="status">販売状態</th>
<th class="edit">操作</th>
</tr>
<!-- foreach start -->


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
      echo "<td><input type='checkbox' name='check[]' value='".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID']."'><input type='number' class='sale_flg' htl_pln_id=".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID']." min='1' max='10' value='".$plan['SORT_NUM']."'></td>";
      echo "<td>".$plan['PLN_ID']."</td>";
      echo "<td>".$plan['PLN_NAME']."</td>";
      echo "<td>".$plan['PLAN_START'].'～'.$plan['PLAN_END']."</td>";
      echo "<td>";
      echo "<ul class='lang'>";
      echo "<li class='active'>".Asset::img('ico_lang01_jp.png',array('alt' => ''))."</li>";
      if ($plan['en_flg'] == '1') {
          echo "<li class='active'>".Asset::img('ico_lang01_en.png',array('alt' => ''))."</li>";  
      }else{
          echo "<li></li>";
      }

      if ($plan['ch_flg'] == '1') {
          echo "<li class='active'>".Asset::img('ico_lang01_ch.png',array('alt' => ''))."</li>";  
      }else{
          echo "<li></li>";
      }

      if ($plan['chh_flg'] == '1') {
          echo "<li class='active'>".Asset::img('ico_lang01_tw.png',array('alt' => ''))."</li>";  
      }else{
          echo "<li></li>";
      }

      if ($plan['ko_flg'] == '1') {
          echo "<li class='active'>".Asset::img('ico_lang01_kr.png',array('alt' => ''))."</li>";  
      }else{
          echo "<li></li>";
      }

      echo "</ul>";
      echo "</td>";
      echo "<td class='status'>";
      echo "<ul class='clearfix'>";
      echo "<li><input type='radio' name='saleStatus".$i."' id='saleStatus".$i."01' ".$stop_flg."><label for='saleStatus".$i."01' class='stop' htl_pln_id=".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].">停止</label></li>";
      echo "<li><input type='radio' name='saleStatus".$i."' id='saleStatus".$i."02' ".$sale_flg."><label for='saleStatus".$i."02' class='onsale' htl_pln_id=".$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'].">販売</label></li>";
      echo "</ul>";
      echo "</td>";
      echo "<td>";
      echo "<div class='edit'>";
      echo "<input type='button' name='edit'>";
      echo "<ul class='balloon'>";
      echo "<li><a>".Html::anchor('admin/plan/edit/'.$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'] ,'編集する')."</a></li>";
      echo "<li><a>".Html::anchor('admin/plan/secret_plan/'.$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'] ,'シークレット')."</a></li>";
      echo "<li><a>".Html::anchor('admin/plan/delete/'.$plan['HTL_ID'].EXPLODE.$plan['PLN_ID'] ,'削除する')."</a></li>";
      echo "</ul>";
      echo "</div>";
      echo "</td>";
      echo "</tr>";
    }

?>

</table>
</div>
<div class="tableCheck tableCheckBottom clearfix">
<table class="planCheck">
<tr>
<td><input type="button" name="checkAll" value="全てをチェックする"></td>
<td><input type="button" name="removeAll" value="全てのチェックをはずす"></td>
<td>チェックしたプランを
<div class="edit">
<input type="button" name="editAll">
<ul class="balloon">
<li><input type='submit' name='action' value='販売する'></li>
<li><input type='submit' name='action' value='停止する'></li>
<li><input type='submit' name='action' value='削除する'></li>
</ul>
</div>
</td>
</tr>
</form>

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
