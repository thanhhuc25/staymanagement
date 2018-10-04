contents -->
<div id="contents">
<div class="inner">
<h2>宿泊プランの編集</h2>
<p style="color: red;"><?php echo $error;?></p>
<div class="edit planEdit">
<!-- <form action="" method="post"> -->
<?php echo Form::open(array('action' => 'admin/plan/'.$action, 'enctype' => 'multipart/form-data'));?>
<input type="hidden" name="HtlPlnID" id="HtlPlnID" value="<?php echo $plan['HtlPlnID'];?>">
<div class="editBox">
<div class="editTab clearfix">
<ul>
<li><a href="javascript:void(0);"><span>基本設定</span></a></li>
<li><a href="javascript:void(0);"><span>関連情報設定</span></a></li>
<li><a href="javascript:void(0);"><span>部屋タイプ設定</span></a></li>
<li><a href="javascript:void(0);"><span>表示設定</span></a></li>
</ul>
</div>
<div class="editInner">
<div class="section">
<h3>基本設定</h3>
<table>
<tr>
<th>宿泊プランID</th>
<td><?php echo $plan_id;?></td>
</tr>
<!-- <tr>
<th class="required">宿泊プラン種類</th>
<td>
<ul class="clearfix">
<li><input type="radio" name="planType" id="planType01"><label for="planType01">通常プラン</label></li>
<li><input type="radio" name="planType" id="planType02"><label for="planType02">コーポレートプラン</label></li>
</ul>
</td>
</tr> -->
<tr>
<th class="required">宿泊プラン名</th>
<td class="name">
<ul>
<li><input type="text" name="planNameJP" id="planName01" value="<?php echo $plan['PLN_NAME'];?>"></li>
<li><span>英語表記</span><input type="text" name="planNameEN" id="planName02" value="<?php echo $plan['PLN_EN_NAME'];?>"></li>
<li><span>繁体字表記</span><input type="text" name="planNameCHH" id="planName03" value="<?php echo $plan['PLN_CHH_NAME'];?>"></li>
<li><span>簡体字表記</span><input type="text" name="planNameCH" id="planName04" value="<?php echo $plan['PLN_CH_NAME'];?>"></li>
<li><span>韓国語表記</span><input type="text" name="planNameKO" id="planName05" value="<?php echo $plan['PLN_KO_NAME'];?>"></li>
</ul>
</td>
</tr>
<tr>
<th class="required">販売期間</th>
<td class="term">
<ul class="clearfix">
<li><input type="text" name="saleTermStart" id="saleTerm01" value="<?php echo $plan['PLAN_START'];?>"><label for="saleTerm01"></label></li>
<li><span>～</span></li>
<li><input type="text" name="saleTermEnd" id="saleTerm02" value="<?php echo $plan['PLAN_END'];?>"><label for="saleTerm02"></label></li>
</ul>
</td>
</tr>
<tr>
<th class="required">表示期間</th>
<td class="term">
<ul class="clearfix">
<li><input type="text" name="showTermStart" id="showTerm01" value="<?php echo $plan['DISP_START'];?>"><label for="showTerm01"></label></li>
<li><span>～</span></li>
<li><input type="text" name="showTermEnd" id="showTerm02" value="<?php echo $plan['DISP_END'];?>"><label for="showTerm02"></label></li>
</ul>
</td>
</tr>
<tr>
<th class="required">手仕舞い</th>
<td>
<ul>
<!-- <li><input type="checkbox" name="closingOutCB" id="closingOut01" <?php echo $tejimai_flg;?>><label for="closingOut01">当日未明の申込みを許可する</label></li> -->
<li><?php echo Form::select('closingOutCB',$tejimai_flg,$tejimai_type,array('id'=>'closingOut01','style'=>'width:auto;margin-left:0;'));?></li>
<li id="closingout"><?php echo Form::select('closingOut2',$plan['PLN_LIMIT_DAY'],$tejimai_day,array('style'=>'width:auto;margin-left:0;'));?>の<?php echo Form::select('closingOut',$plan['PLN_LIMIT_TIME'],$tejimai_time);?>時まで</li>
</ul>
</td>
</tr>
<tr>
<th class="required">宿泊数設定</th>
<td class="range">
<ul class="clearfix">
<li><?php echo Form::select('staysNumLower',$plan['PLN_STAY_LOWER'],$stay_list);?>泊</li>
<li><span>～</span></li>
<li><?php echo Form::select('staysNumUpper',$plan['PLN_STAY_UPPER'],$stay_list);?>泊</li>
</ul>
</td>
</tr>
<!-- <tr>
<th class="required">販売先設定</th>
<td>
<ul class="clearfix">
<li><input type="radio" name="saleMobile" id="saleMobile01"><label for="saleMobile01">PCサイトのみ</label></li>
<li><input type="radio" name="saleMobile" id="saleMobile02"><label for="saleMobile02">携帯サイトのみ</label></li>
<li><input type="radio" name="saleMobile" id="saleMobile03"><label for="saleMobile03">PC・携帯両サイト</label></li>
</ul>
</td>
</tr> -->
<tr>
<th class="required">販売状態</th>
<td class="status">
<ul class="clearfix">
<li><input type="radio" class="stop" name="saleStatus" id="saleStatus01" value="0" <?php echo $stop_flg;?> ><label for="saleStatus01" class="stop">停止</label></li>
<li><input type="radio" class="onsale" name="saleStatus" id="saleStatus02" value="1" <?php echo $sale_flg;?> ><label for="saleStatus02" class="onsale">販売</label></li>
</ul>
</td>
</tr>
</table>
</div><!-- /section -->
<div class="section">
<h3>関連情報設定</h3>
<table>
<tr>
<th>宿泊プランカテゴリ</th>
<td class="category">
<ul class="clearfix">
<?php

  foreach ($category as $key => $value) {
    if ($value['CATEGORY_ID'] == $plan['CATEGORY_ID1'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";
    
    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY2_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";
    
    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY3_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";

    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY4_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";

    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY5_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";

    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY6_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";

    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY7_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";

    }else if ($value['CATEGORY_ID'] == $plan['CATEGORY8_ID'] ) {
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  checked><label>".$value['CATEGORY_NAME']."</label></li>";

    }else{
      echo "<li><input type='checkbox' name='planType[]'value='".$htl_id.EXPLODE.$value['CATEGORY_ID']."'  ><label>".$value['CATEGORY_NAME']."</label></li>";
    }

  }

?>

</ul><p>※カテゴリは８つまで選択できます。</p>
<p class="btn"><input type="button" name="planCategoryEdit" value="宿泊プランカテゴリ編集はこちら" onclick="location.href='/admin/plan/category/<?php echo $plan_id;?>'"></p>
</td>
</tr>
<tr>
<th>チェックイン時刻設定</th>
<td class="checkinTime">
<ul class="timeSelect">
<?php
  if (count($checkinTimes) > 0) {
    foreach ($checkinTimes as $key => $checkinTime) {
      echo "<li>".$checkinTime."<a href='javascript:void(0);'><input type='hidden' name='c_times[]' value='".$checkinTime."'></a></li>";
    }
  }
?>

</ul>
<p class="btn"><input type="button" name="timeDelete" value="時刻を全て削除"></p>
<div class="timeBalloon">
<ul class="clearfix">
<li><select name="checkinTime" id="checkinTime01">
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
</select>時</li>
<li><span>～</span></li>
<li><select name="checkinTime" id="checkinTime02">
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
</select>時まで</li>
</ul>
<ul class="clearfix">
<li><input type="radio" name="checkinEvery" id="checkinEvery01" checked="checked" value="0"><label for="checkinEvery01">1時間ごと</label></li>
<li><input type="radio" name="checkinEvery" id="checkinEvery02" value="1"><label for="checkinEvery02">30分ごと</label></li>
</ul>
<p class="btn"><input type="button" name="timeAdd" id="timeAdd" value="時刻を追加"></p>
</div>
</td>
</tr>
</table>
</div><!-- /section -->

<div class="section" id="rmtypeSection">
<h3>部屋タイプ設定</h3>
<p class="leadTxt">より詳細な料金につきましては、こちらのボタンより設定頂けます。<input type="button" name="priceEdit" value="料金設定へ" onclick="location.href='/admin/price'" ></p>
<p class="rightBtn">
<select name="rtype" id="selectedRoomType">
<?php 
    foreach ($unuse_rtype as $key => $value) {
      echo "<option value='".$value['HtlTypeID']."'>".$value['TYPE_NAME']."</option>";
    }
?>
</select>

<input type="button" name="add" id="addRoomType" value="部屋タイプを追加する"></p>
<div class="sectionInner">


<?php
    foreach ($use_rtypes as $key => $value) {
    echo "<div class='subSection'>";
    echo "<div class='ttlBox clearfix'>";
    echo "<h4>".$value['TYPE_NAME']."</h4><input type='hidden' name='rtype_id[]' value='".$value['TYPE_ID']."'>";
    echo "<p class='btn'><input type='button' name='edit'><input type='button' class='roomType' htlplntype='".$value['HTL_ID'].EXPLODE.$value['PLN_ID'].EXPLODE.$value['TYPE_ID']."' name='delete'></p>";
    echo "</div>";
    echo "<div class='tableBox'>";
    echo "<table>";
    echo "<tr>";
    echo "<th class='required'>定員</th>";
    echo "<td class='range'>";
    echo "<ul class='clearfix'>";
    echo "<li><select name='capacityNumMin_".$value['TYPE_ID']."' id='capacityNum0101' class='chgval'>";
    for ($i=$value['CAP_MIN']; $i <= $value['CAP_MAX']; $i++) { 
      if ($value['PLN_MIN'] == $i) {
        echo "<option value='".$i."' selected>".$i."</option>";
      }else{
        echo "<option value='".$i."'>".$i."</option>";
      }
    }
    echo "</select>名</li>";
    echo "<li><span>～</span></li>";
    echo "<li><select name='capacityNumMax_".$value['TYPE_ID']."' id='capacityNum0102' class='chgval'>";
    for ($i=$value['CAP_MIN']; $i <= $value['CAP_MAX']; $i++) { 
      if ($value['PLN_MAX'] == $i) {
        echo "<option value='".$i."' selected>".$i."</option>";
      }else{
        echo "<option value='".$i."'>".$i."</option>";
      }
    }
    echo "</select>名</li>";
    echo "</ul>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<th class='required'>基本大人料金</th>";
    echo "<td class='basicPrice'>";
    echo "<p class='attention'>※特定日を設定した状態で以下の料金を変更すると料金の整合性が取れなくなります。<br>変更後は必ず「料金管理」機能で特定日料金をご確認ください。</p>";
    echo "<table>";
    echo "<tr>";
    for ($i=$value['CAP_MIN']; $i <= $value['CAP_MAX']; $i++) { 
      echo "<td>".$i."名様</td>";  
    }
    // echo "<td>1名様</td>";
    // echo "<td>2名様</td>";
    // echo "<td>3名様</td>";
    // echo "<td>4名様</td>";
    // echo "<td>5名様</td>";
    // echo "<td>6名様</td>";
    echo "</tr>";
    echo "<tr>";
    for ($i=$value['CAP_MIN']; $i <= $value['CAP_MAX']; $i++) { 
      echo "<td><input type='text' name='price".$i."_".$value['TYPE_ID']."' id='price0101' value='".$value['PLN_CHG_PERSON'.$i]."' class='chgval' >円/名</td>";
    }
    // echo "<td><input type='text' name='price1_".$value['TYPE_ID']."' id='price0101' value='".$value['PLN_CHG_PERSON1']."' class='chgval' >円/名</td>";
    // echo "<td><input type='text' name='price2_".$value['TYPE_ID']."' id='price0102' value='".$value['PLN_CHG_PERSON2']."' class='chgval' >円/名</td>";
    // echo "<td><input type='text' name='price3_".$value['TYPE_ID']."' id='price0103' value='".$value['PLN_CHG_PERSON3']."' class='chgval' >円/名</td>";
    // echo "<td><input type='text' name='price4_".$value['TYPE_ID']."' id='price0104' value='".$value['PLN_CHG_PERSON4']."' class='chgval' >円/名</td>";
    // echo "<td><input type='text' name='price5_".$value['TYPE_ID']."' id='price0105' value='".$value['PLN_CHG_PERSON5']."' class='chgval' >円/名</td>";
    // echo "<td><input type='text' name='price6_".$value['TYPE_ID']."' id='price0106' value='".$value['PLN_CHG_PERSON6']."' class='chgval' >円/名</td>";
    echo "</tr>";
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<th class='required'>子供料金</th>";
    echo "<td class='childPrice'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>使用可否</td>";
    echo "<td>料金・単位</td>";
    echo "<td>人数換算</td>";
    echo "</tr>";
    echo "<tr>";
    if ($value['PLN_CAL_CHILD1'] == 1) {$calflg1='checked';$calflg2='';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD1'] == 2) {$calflg1='';$calflg2='checked';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD1'] == 3) {$calflg1='';$calflg2='';$calflg3='checked'; }
    else {$calflg1=''; $calflg2=''; $calflg3=''; }

    if ($value['PLN_FLG_CHILD1'] == 1) { $checked = 'checked'; }else{ $checked = ''; }
    echo "<td><input type='checkbox' name='child1_".$value['TYPE_ID']."' id='child0101".$key."' ".$checked." class='chgval'><label for='child0101".$key."' >小学生</label></td>";
    echo "<td>";
    echo "<input type='text' name='childprice1_".$value['TYPE_ID']."' value='".$value['PLN_VAL_CHILD1']."' id='childprice0101' class='chgval' >";
    echo "<input type='radio' name='cal1_".$value['TYPE_ID']."' id='unit010101".$key."' value='1' ".$calflg1." class='chgval' ><label for='unit010101".$key."' >円</label>";
    echo "<input type='radio' name='cal1_".$value['TYPE_ID']."' id='unit010102".$key."' value='2' ".$calflg2." class='chgval' ><label for='unit010102".$key."' >％</label>";
    echo "<input type='radio' name='cal1_".$value['TYPE_ID']."' id='unit010103".$key."' value='3' ".$calflg3." class='chgval' ><label for='unit010103".$key."' >円引き</label>";
    echo "</td>";
    if ($value['PLN_CNT_CHILD1'] == 1) {$checked = 'checked';}else{$checked = '';}
    echo "<td><input type='checkbox' name='asadult1_".$value['TYPE_ID']."' id='asadult0101".$key."'  ".$checked." class='chgval'><label for='asadult0101".$key."'>大人として数える</label></td>";
    echo "</tr>";
    echo "<tr>";
    if ($value['PLN_CAL_CHILD2'] == 1) {$calflg1='checked';$calflg2='';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD2'] == 2) {$calflg1='';$calflg2='checked';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD2'] == 3) {$calflg1='';$calflg2='';$calflg3='checked'; }
    else {$calflg1=''; $calflg2=''; $calflg3=''; }

    if ($value['PLN_FLG_CHILD2'] == 1) { $checked = 'checked'; }else{ $checked = ''; }
    echo "<td><input type='checkbox' name='child2_".$value['TYPE_ID']."' id='child0102".$key."' ".$checked."  class='chgval'><label for='child0102".$key."'>幼児（食事あり・寝具あり）</label></td>";
    echo "<td>";
    echo "<input type='text' name='childprice2_".$value['TYPE_ID']."' value='".$value['PLN_VAL_CHILD2']."' id='childprice0102'  class='chgval'>";
    echo "<input type='radio' name='cal2_".$value['TYPE_ID']."' id='unit010201".$key."' value='1' ".$calflg1." class='chgval'><label for='unit010201".$key."'>円</label>";
    echo "<input type='radio' name='cal2_".$value['TYPE_ID']."' id='unit010202".$key."' value='2' ".$calflg2." class='chgval'><label for='unit010202".$key."'>％</label>";
    echo "<input type='radio' name='cal2_".$value['TYPE_ID']."' id='unit010203".$key."' value='3' ".$calflg3." class='chgval'><label for='unit010203".$key."'>円引き</label>";
    echo "</td>";
    if ($value['PLN_CNT_CHILD2'] == 1) {$checked = 'checked';}else{$checked = '';}
    echo "<td><input type='checkbox' name='asadult2_".$value['TYPE_ID']."' id='asadult0102".$key."'  ".$checked." class='chgval'><label for='asadult0102".$key."'>大人として数える</label></td>";
    echo "</tr>";
    echo "<tr>";
    if ($value['PLN_CAL_CHILD3'] == 1) {$calflg1='checked';$calflg2='';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD3'] == 2) {$calflg1='';$calflg2='checked';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD3'] == 3) {$calflg1='';$calflg2='';$calflg3='checked'; }
    else {$calflg1=''; $calflg2=''; $calflg3=''; }    

    if ($value['PLN_FLG_CHILD3'] == 1) { $checked = 'checked'; }else{ $checked = ''; }
    echo "<td><input type='checkbox' name='child3_".$value['TYPE_ID']."' id='child0103".$key."' ".$checked." class='chgval'><label for='child0103".$key."'>幼児（食事あり・寝具なし）</label></td>";
    echo "<td>";
    echo "<input type='text' name='childprice3_".$value['TYPE_ID']."' value='".$value['PLN_VAL_CHILD3']."' id='childprice0103' class='chgval' >";
    echo "<input type='radio' name='cal3_".$value['TYPE_ID']."' id='unit010301".$key."' value='1' ".$calflg1." class='chgval' ><label for='unit010301".$key."'>円</label>";
    echo "<input type='radio' name='cal3_".$value['TYPE_ID']."' id='unit010302".$key."' value='2' ".$calflg2." class='chgval' ><label for='unit010302".$key."'>％</label>";
    echo "<input type='radio' name='cal3_".$value['TYPE_ID']."' id='unit010303".$key."' value='3' ".$calflg3." class='chgval' ><label for='unit010303".$key."'>円引き</label>";
    echo "</td>";
    if ($value['PLN_CNT_CHILD3'] == 1) {$checked = 'checked';}else{$checked = '';}
    echo "<td><input type='checkbox' name='asadult3_".$value['TYPE_ID']."' id='asadult0103".$key."'  ".$checked." class='chgval'><label for='asadult0103".$key."'>大人として数える</label></td>";
    echo "</tr>";
    echo "<tr>";
    if ($value['PLN_CAL_CHILD4'] == 1) {$calflg1='checked';$calflg2='';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD4'] == 2) {$calflg1='';$calflg2='checked';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD4'] == 3) {$calflg1='';$calflg2='';$calflg3='checked'; }
    else {$calflg1=''; $calflg2=''; $calflg3=''; }

    if ($value['PLN_FLG_CHILD4'] == 1) { $checked = 'checked'; }else{ $checked = ''; }    
    echo "<td><input type='checkbox' name='child4_".$value['TYPE_ID']."' id='child0104".$key."' ".$checked." class='chgval' ><label for='child0104".$key."'>幼児（食事なし・寝具あり）</label></td>";
    echo "<td>";
    echo "<input type='text' name='childprice4_".$value['TYPE_ID']."' value='".$value['PLN_VAL_CHILD4']."' id='childprice0104' class='chgval' >";
    echo "<input type='radio' name='cal4_".$value['TYPE_ID']."' id='unit010401".$key."' value='1' ".$calflg1." class='chgval' ><label for='unit010401".$key."'>円</label>";
    echo "<input type='radio' name='cal4_".$value['TYPE_ID']."' id='unit010402".$key."' value='2' ".$calflg2." class='chgval' ><label for='unit010402".$key."'>％</label>";
    echo "<input type='radio' name='cal4_".$value['TYPE_ID']."' id='unit010403".$key."' value='3' ".$calflg3." class='chgval' ><label for='unit010403".$key."'>円引き</label>";
    echo "</td>";
    if ($value['PLN_CNT_CHILD4'] == 1) {$checked = 'checked';}else{$checked = '';}
    echo "<td><input type='checkbox' name='asadult4_".$value['TYPE_ID']."' id='asadult0104".$key."'  ".$checked." class='chgval'><label for='asadult0104".$key."'>大人として数える</label></td>";
    echo "</tr>";
    echo "<tr>";
    if ($value['PLN_CAL_CHILD5'] == 1) {$calflg1='checked';$calflg2='';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD5'] == 2) {$calflg1='';$calflg2='checked';$calflg3=''; }
    else if ($value['PLN_CAL_CHILD5'] == 3) {$calflg1='';$calflg2='';$calflg3='checked'; }
    else {$calflg1=''; $calflg2=''; $calflg3=''; }

    if ($value['PLN_FLG_CHILD5'] == 1) { $checked = 'checked'; }else{ $checked = ''; }    
    echo "<td><input type='checkbox' name='child5_".$value['TYPE_ID']."' id='child0105".$key."' ".$checked." class='chgval'><label for='child0105".$key."'>幼児（食事なし・寝具なし）</label></td>";
    echo "<td>";
    echo "<input type='text' name='childprice5_".$value['TYPE_ID']."' value='".$value['PLN_VAL_CHILD5']."' id='childprice0105' class='chgval' >";
    echo "<input type='radio' name='cal5_".$value['TYPE_ID']."' id='unit010501".$key."' value='1' ".$calflg1." class='chgval' ><label for='unit010501".$key."'>円</label>";
    echo "<input type='radio' name='cal5_".$value['TYPE_ID']."' id='unit010502".$key."' value='2' ".$calflg2." class='chgval' ><label for='unit010502".$key."'>％</label>";
    echo "<input type='radio' name='cal5_".$value['TYPE_ID']."' id='unit010503".$key."' value='3' ".$calflg3." class='chgval' ><label for='unit010503".$key."'>円引き</label>";
    echo "</td>";
    if ($value['PLN_CNT_CHILD5'] == 1) {$checked = 'checked';}else{$checked = '';}
    echo "<td><input type='checkbox' name='asadult5_".$value['TYPE_ID']."' id='asadult0105".$key."'  ".$checked." class='chgval'><label for='asadult0105".$key."'>大人として数える</label></td>";
    echo "</tr>";
    echo "<tr>";
    if ($value['PLN_CAL_CHILD6'] == 1) {$calflg1='checked'; }else {$calflg1=''; } 

    if ($value['PLN_FLG_CHILD6'] == 1) { $checked = 'checked'; }else{ $checked = ''; }   
    echo "<td><input type='checkbox' name='child6_".$value['TYPE_ID']."' id='child0106".$key."' ".$checked." class='chgval' ><label for='child0106".$key."'>乳児（入館料）</label></td>";
    echo "<td>";
    echo "<input type='text' name='childprice6_".$value['TYPE_ID']."' value='".$value['PLN_VAL_CHILD6']."' id='childprice0106' class='chgval' >";
    echo "<input type='radio'  name='cal6_".$value['TYPE_ID']."' id='unit010601".$key."' value='1' ".$calflg1."  class='chgval'><label for='unit010601".$key."'>円</label>";
    echo "</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    }


?>

</div>
</div>



<div class="section">
<h3>表示設定</h3>
<div class="grayBox">
<h4>プラン情報</h4>
<table>
<tr>
<th colspan="3">プラン画像 (推奨サイズ:ヨコ657px,タテ444px)</th>
</tr>
<tr>
<th><p><label class="manageImg">画像を管理<input type="file" name="picFile1" class="uploadHtlImg" htlPlnId="1_1_1" style="display: none;"></label></p><?php echo Asset::img($img1,array('height' => '100')) ?></th>
<th><p><label class="manageImg">画像を管理<input type="file" name="picFile2" class="uploadHtlImg" htlPlnId="1_1_2" style="display: none;"></label></p><?php echo Asset::img($img2,array('height' => '100')) ?></th>
<th><p><label class="manageImg">画像を管理<input type="file" name="picFile3" class="uploadHtlImg" htlPlnId="1_1_3" style="display: none;"></label></p><?php echo Asset::img($img3,array('height' => '100')) ?></th>

</td>
</tr>
</table>
<dl class="explan">
<dt>説明文</dt>
<dd>
<div class="txtBox">
<p class="txt"><a href="javascript:void(0);">日本語</a></p>
<p class="input"><textarea name="explainJp" value=""><?php echo $plan['JP_CAP_PC_LIGHT'];?></textarea></p>
</div>
<div class="txtBox">
<p class="txt"><a href="javascript:void(0);">英語</a></p>
<p class="input"><textarea name="explainEn"><?php echo $plan['EN_CAP_PC_LIGHT'];?></textarea></p>
</div>
<div class="txtBox">
<p class="txt"><a href="javascript:void(0);">繁体字</a></p>
<p class="input"><textarea name="explainTw"><?php echo $plan['CHH_CAP_PC_LIGHT'];?></textarea></p>
</div>
<div class="txtBox">
<p class="txt"><a href="javascript:void(0);">簡体字</a></p>
<p class="input"><textarea name="explainCh"><?php echo $plan['CH_CAP_PC_LIGHT'];?></textarea></p>
</div>
<div class="txtBox">
<p class="txt"><a href="javascript:void(0);">韓国語</a></p>
<p class="input"><textarea name="explainKr"><?php echo $plan['KO_CAP_PC_LIGHT'];?></textarea></p>
</div>
</dd>
</dl>
</div>
</div><!-- /section -->
</div>
</div>
<ul class="editBtn">
<?php if($plan_id != '新規'){echo "<li><input type='button' name='delete' value='削除する' onclick='delete_plan()'></li>";} ?>
<!-- <li><input type="button" name="delete" value="削除する"></li> -->
<li><input type="submit" name="update" value="更新する"></li>
</ul>
<!-- </form> -->
<?php echo Form::close();?>
</div>
</div>
</div>
