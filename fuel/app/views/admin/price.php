<!-- contents -->
<div id="contents">
<div class="inner">
<h2>料金管理</h2>
<div class="editTop">
<p class="leadTxt">宿泊プランと年月を選択し「表示する」ボタンを押すと、現在の販売状態ならびに料金カレンダーが表示されます。</p>
<div class="tableSelect clearfix">
<table>
<tr>
<th class="required">宿泊プラン</th>
<td><select name="planType">
<?php 
  foreach ($plan as $key => $value) {
    if ($selected_plan['PLN_ID'] == $value['PLN_ID']) {
      echo "<option value='".$value['HTL_ID'].EXPLODE.$value['PLN_ID']."' selected>".$value['PLN_NAME']."</option>";
    }else{
      echo "<option value='".$value['HTL_ID'].EXPLODE.$value['PLN_ID']."'>".$value['PLN_NAME']."</option>";
    }
  }

?>
</select></td>
</tr>
</table>
<table>
<tr>
<th class="required">年月</th>
<td><select name="planYear">
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
<td><select name="planMonth">
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
<p class="btn"><input type="button" onclick="showPrice();" name="showTable" value="表示する"></p>
</div>

<div class="blueBox">
<h3><?php echo $selected_plan['PLN_NAME']; ?><input type="hidden" name="HtlPlnID" id="HtlPlnID" value="<?php echo $selected_plan['HTL_ID'].EXPLODE.$selected_plan['PLN_ID'] ;?>"></h3>
<div class="tableTop clearfix">
<table>
<th>販売状態</th>
<td class="status"><span>
<?php 
  if ($selected_plan['PLN_USE_FLG'] == '1') {
    echo "<span class='onsale'>販売</span>";
  }else{
    echo "<span class='stop'>停止</span>"; 
  }
?>
</span></td>
</table>
<table>
<th>販売期間</th>
<td class="term"><?php echo $selected_plan['PLAN_START'].' ～ '.$selected_plan['PLAN_END'];?></td>
</table>
</div>
<div class="monthPager">
<table>
<tr>
<td class="prev"><input type="button" name="prev" value="前の月" onclick="preMonth();"></td>
<td><?php echo $selected_year."年 ".$selected_month."月";?><input type="hidden" name="date" id="PlnDate" value="<?php echo $selected_year.EXPLODE.$selected_month;?>"></td>
<td class="next"><input type="button" name="next" value="次の月" onclick="nextMonth();" ></td>
</tr>
</table>
</div>
<div class="editBox">
<div class="editTab clearfix">
<ul>
<?php
  foreach ($rtype as $key => $value) {
    echo "<li><a href='javascript:void(0);'><span>".$value['TYPE_NAME']."</span></a></li>";
  }
?>
</ul>
</div>
<div class='editInner'>
<?php
  foreach ($rtype as $key => $value) {
    // echo "";

    echo "<div class='section'>";
    echo "<div class='tableCalendar'>";
    echo "<table>";
    echo "<tr>";
    echo "<th>日</th>";
    echo "<th>月</th>";
    echo "<th>火</th>";
    echo "<th>水</th>";
    echo "<th>木</th>";
    echo "<th>金</th>";
    echo "<th>土</th>";
    echo "</tr>";

    $dayCnt = 1;
    for ($k=1; $k <= 42; $k++) { 
      if ( $k == 1 || $k == 8 || $k == 15 || $k == 22 || $k == 29 || $k == 36) {echo "<tr>";}
      if ($k <= $empty) {
        echo "<td></td>";
      }else if($dayCnt > $days_in_month){
        echo "<td></td>";
      }else{
        echo "<td><dl>";
        if (isset($holiday_list[$dayCnt])) {
          echo "<dt style=' background: #fadada;'>".$dayCnt."日</dt>";
        }else{
          echo "<dt>".$dayCnt."日</dt>";
        }
        
        echo "<dd><ul>";
        if ( isset( $value['EXCEPTIONDAYS'][$dayCnt] ) ) {
           for ($s=$value['CAP_MIN']; $s <= $value['CAP_MAX'] ; $s++) { 
              $num = $value['PLN_CHG_PERSON'.$s] + $value['EXCEPTIONDAYS'][$dayCnt]['PLN_CHG_EXCEPTION'.$s];
              echo "<li>".$s."名<input type='text' name='price' class='chgval' day='".$dayCnt."' t_id='".$value['TYPE_ID']."' n='".$s."' value='".$num."'>円</li>";
            }
        }else{
            for ($s=$value['CAP_MIN']; $s <= $value['CAP_MAX'] ; $s++) { 
              echo "<li>".$s."名<input type='text' name='price' class='chgval' day='".$dayCnt."' t_id='".$value['TYPE_ID']."' n='".$s."' value='".$value['PLN_CHG_PERSON'.$s]."'>円</li>";
            }
        }
        // echo "<li>1名<input type='text' name='price'>円</li>";
        // echo "<li>2名<input type='text' name='price'>円</li>";
        echo "</ul></dd>";
        echo "</dl></td>";
        $dayCnt++;
      }
      if ( $k == 7 || $k == 14 || $k == 21 || $k == 28 || $k == 35 || $k == 42) {echo "</tr>";}
    }
    // echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

  }
?>



</div>
</div>
</div>
</div>
</div>
</div>
<!-- /contents -->