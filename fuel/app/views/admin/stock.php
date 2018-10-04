<!-- contents -->
<div id="contents">
<div class="inner">
<h2>在庫管理</h2>
<div class="editTop stockEdit">
<p class="leadTxt">部屋と年月を選択し「表示する」ボタンを押すと、現在の販売状態ならびに料金カレンダーが表示されます。</p>
<div class="tableSelect clearfix">
<table>
<tr>
<th class="required">部屋タイプ</th>
<td><select name="roomType">
<?php 
  foreach ($rtype as $key => $value) {
    if ($selected_rtype['TYPE_ID'] == $value['TYPE_ID']) {
      echo "<option value='".$value['HTL_ID'].EXPLODE.$value['TYPE_ID']."' selected>".$value['TYPE_NAME']."</option>";
    }else{
      echo "<option value='".$value['HTL_ID'].EXPLODE.$value['TYPE_ID']."'>".$value['TYPE_NAME']."</option>";
    }
  }

?>
</select></td>
</tr>
</table>

<table>
<tr>
<th class="required">年月</th>
<td><select name="roomYear">
<?php 
  foreach ($year_list as $key => $value) {
    if ($value == $selected_year) {
      echo "<option value='".$value."' selected>".$value."</option>";
    }else{
      echo "<option value='".$value."'>".$value."</option>";
    }
  }
?>
</select>年</td>
<td><select name="roomMonth">
<?php 
  foreach ($month_list as $key => $value) {
    if ($value == $selected_month) {
      echo "<option value='".$value."' selected>".$value."</option>";
    }else{
      echo "<option value='".$value."' >".$value."</option>";
    }
  }
?>
</select>月</td>
</tr>
</table>

<p class="btn"><input type="button" onclick="showStock();" name="showTable" value="表示する"></p>
</div>
<div class="blueBox">
<h3><?php echo $selected_rtype['TYPE_NAME']; ?><input type="hidden" name="HtlTypeID" id="HtlTypeID" value="<?php echo $selected_rtype['HTL_ID'].EXPLODE.$selected_rtype['TYPE_ID'] ;?>"></h3>
<div class="tableTop clearfix">
<table>
<th>販売状態</th>
<?php 
  if ($selected_rtype['RM_USE_FLG'] == 1) {
    echo "<td class='status'><span><span class='onsale'>販売</span></span></td>";
  }else{
    echo "<td class='status'><span><span class='stop'>停止</span></span></td>";
  }
?>
</table>
<table>
<th>総提供室数</th>
<td class="number" id="totalrmnum"><?php echo $selected_rtype['RM_NUM']; ?>室</td>
</table>
</div>
<div class="monthPager">
<table>
<tr>
<td class="prev"><input type="button" name="prev" value="前の月" onclick="preMonth();"></td>
<td><?php echo $selected_year."年 ".$selected_month."月";?><input type="hidden" name="date" id="selectedDate" value="<?php echo $selected_year.EXPLODE.$selected_month;?>"></td>
<td class="next"><input type="button" name="next" value="次の月" onclick="nextMonth();"></td>
</tr>
</table>
</div>
<div class="editBox">
<div class="editTab clearfix">
<ul>
<li><a href="javascript:void(0);"><span>販売中のプラン</span></a></li>
<li><a href="javascript:void(0);"><span>停止中のプラン</span></a></li>
</ul>
</div>
<div class="editInner">

<?php
    echo "<div class='section'>";
    echo "<div class='tablePlan'>";
    echo "<table>";
    echo "<tr id='onsaletr'>";
    echo "<th>提供室数</th>";

    for($k=1; $k <= $days_in_month; $k++){
        if ( $k == $sun_start || $k == $sun_start+7 || $k == $sun_start+14 || $k == $sun_start+21 || $k == $sun_start+28 || $k == $sun_start+35 || isset($holiday_list[$k])) {echo "<td class='sun'><dl>";
        }elseif( $k == $sun_start -1 || $k == $sun_start+6 || $k == $sun_start+13 || $k == $sun_start+20 || $k == $sun_start+27 || $k == $sun_start+34 ){echo "<td class='sat'><dl>";
        }else{echo "<td><dl>";}
        echo "<dt>".$k."日</dt>";
        echo "<dd>";
        echo "<p><span>売済</span>：<span>残室</span></p>";
        if (isset($day_saled_list[$k])) { $num = $day_saled_list[$k]; }else{ $num='0'; }
        if (isset($stock_list[$k])) { $s_num = $stock_list[$k]; }else{ $s_num='0'; }
        $rnum = $selected_rtype['RM_NUM'] - $num + $s_num;
        echo "<p><span>".$num."</span>：<input type='text' name='stock' d='".$k."'  s='".$num."' value='".$rnum."'></p>";
        echo "<ul class='status'>";
        echo "<li class='stop' day='".$k."' >停止する</li>";
        echo "<li class='onsale' day='".$k."'>販売する</li>";
        echo "</ul>";
        echo "</dd>";
        echo "</dl></td>";
    }
    foreach ($use_plan as $key => $value) {
      echo "<tr>";
      echo "<th>".$value['PLN_NAME']."<span class='status'><span class='stop' htl_pln_id=".$value['HTL_ID'].EXPLODE.$value['PLN_ID'].">停止する</span></span></th>";
      for ($i=1; $i <=$days_in_month; $i++) { 
        echo "<td  class='yokoflg_".$value['HTL_ID'].EXPLODE.$value['PLN_ID']."'>";
        if (isset($saled_list[$value['PLN_ID']][$i])) {
          $num = $saled_list[$value['PLN_ID']][$i];
        }else{$num='0';}
        echo "<p>".$num."</p>";
        if (
          ( in_array($i, $stop_list) == true && in_array($i, $stop_list_priority[$value['PLN_ID']]) == true && in_array($i, $use_list_priority[$value['PLN_ID']]) == false ) || 
          ( in_array($i, $stop_list) == true && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) == false ) ||
          ( in_array($i, $stop_list) == false && in_array($i, $stop_list_priority[$value['PLN_ID']]) == true && in_array($i, $use_list_priority[$value['PLN_ID']]) == false )
          ) {
          echo "<ul class='status'>";
          echo "<li class='onsale'  p='".$value['PLN_ID']."' day='".$i."'>販売する</li>";
        }elseif (
          ( in_array($i, $stop_list) == true && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) ==true ) || 
          ( in_array($i, $stop_list) == false && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) ==true ) ||
          ( in_array($i, $stop_list) == false && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) ==false )
          ) {
          echo "<ul class='status'>";
          echo "<li class='stop'  p='".$value['PLN_ID']."' day='".$i."'>停止する</li>";
        }else{
          echo "<ul class=''>";
          echo "<li class='stop'  >error</li>"; 
        }

        echo "</ul>";
        echo "</td>";
      }
      echo "</tr>";
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

  


    echo "<div class='section'>";
    echo "<div class='tablePlan'>";
    echo "<table>";
    echo "<tr>";
    echo "<th>提供室数</th>";
    for($k=1; $k <= $days_in_month; $k++){
        if ( $k == $sun_start || $k == $sun_start+7 || $k == $sun_start+14 || $k == $sun_start+21 || $k == $sun_start+28 || $k == $sun_start+35 || isset($holiday_list[$k])) {echo "<td class='sun'><dl>";
        }elseif( $k == $sun_start -1 || $k == $sun_start+6 || $k == $sun_start+13 || $k == $sun_start+20 || $k == $sun_start+27 || $k == $sun_start+34 ){echo "<td class='sat'><dl>";
        }else{echo "<td><dl>";}
        echo "<dt>".$k."日</dt>";
        echo "<dd>";

        echo "<p><span>売済</span>：<span>残室</span></p>";
        if (isset($day_saled_list[$k])) { $num = $day_saled_list[$k]; }else{ $num='0'; }
        if (isset($stock_list[$k])) { $s_num = $stock_list[$k]; }else{ $s_num='0'; }
        $rnum = $selected_rtype['RM_NUM'] - $num + $s_num;
        echo "<p><span>".$num."</span>：<input type='text' name='stock' d='".$k."'  s='".$num."' value='".$rnum."'></p>";

        
        // echo "<p><span>0</span>：<input type='text' name='stock' value='".$selected_rtype['RM_NUM']."'></p>";
        echo "<ul class='status'>";
        echo "<li class='stop' day='".$k."' >停止する</li>";
        echo "<li class='onsale' day='".$k."'>販売する</li>";
        echo "</ul>";
        echo "</dd>";
        echo "</dl></td>";
    }
    foreach ($un_use_plan as $key => $value) {
      echo "<tr>";
      echo "<th>".$value['PLN_NAME']."<span class='status'><span class='onsale' htl_pln_id=".$value['HTL_ID'].EXPLODE.$value['PLN_ID'].">販売する</span></span></th>";
      for ($i=1; $i <=$days_in_month; $i++) { 
        echo "<td  class='yokoflg_".$value['HTL_ID'].EXPLODE.$value['PLN_ID']."'>";

        if (isset($saled_list[$value['PLN_ID']][$i])) {
          $num = $saled_list[$value['PLN_ID']][$i];
        }else{$num='0';}
        echo "<p>".$num."</p>";
        if (
          ( in_array($i, $stop_list) == true && in_array($i, $stop_list_priority[$value['PLN_ID']]) == true && in_array($i, $use_list_priority[$value['PLN_ID']]) == false ) || 
          ( in_array($i, $stop_list) == true && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) == false ) ||
          ( in_array($i, $stop_list) == false && in_array($i, $stop_list_priority[$value['PLN_ID']]) == true && in_array($i, $use_list_priority[$value['PLN_ID']]) == false )
          ) {
          echo "<ul class='status'>";
          echo "<li class='onsale'  p='".$value['PLN_ID']."' day='".$i."'>販売する</li>";
        }elseif (
          ( in_array($i, $stop_list) == true && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) ==true ) || 
          ( in_array($i, $stop_list) == false && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) ==true ) ||
          ( in_array($i, $stop_list) == false && in_array($i, $stop_list_priority[$value['PLN_ID']]) == false && in_array($i, $use_list_priority[$value['PLN_ID']]) ==false )
          ) {
          echo "<ul class='status'>";
          echo "<li class='stop'  p='".$value['PLN_ID']."' day='".$i."'>停止する</li>";
        }else{
          echo "<ul class=''>";
          echo "<li class='stop'  p='".$value['PLN_ID']."' day='".$i."'>error</li>";
        }
        // echo "<ul class='status'>";
        // echo "<li class='stop'>停止</li>";
        echo "</ul>";
        echo "</td>";
      }
      echo "</tr>";
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
?>



</div>
</div>
</div>
</div>
</div>
</div>
<!-- /contents -->