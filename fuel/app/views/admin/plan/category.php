<!-- contents -->
<div id="contents">
<div class="inner">
<h2><?php echo $title;?></h2>
<p style="color: red;"><?php echo $error; ?></p>
<div class="editTop">
<p class="leadTxt">プラン編集画面で使用するカテゴリをこの画面で編集できます。<br>新たにカテゴリを追加する場合は、一覧表の上にございます各カテゴリ名を記入の上、「カテゴリを追加」ボタンを押してください。</p>
<div class="tablePager clearfix">


<form method="POST">

</div>
<div class="tableCheck tableCheckTop clearfix">
<table class="planCheck">
<tr>
<td><input type="button" name="addCategory" value="カテゴリを追加" onclick="add_category();"></td>
<td><input type="text" name="ja" value="" id="new_ja" placeholder=" カテゴリ名を入力"    style="background-color: white; height: 26px; width: 161px;"></td>
<td><input type="text" name="en" value="" id="new_en" placeholder=" 英語表記"         style="background-color: white; height: 26px; width: 161px;"></td>
<td><input type="text" name="ch" value="" id="new_ch" placeholder=" 中国語表記（簡体字）" style="background-color: white; height: 26px; width: 161px;"></td>
<td><input type="text" name="tw" value="" id="new_tw" placeholder=" 中国語表記（繁体字）" style="background-color: white; height: 26px; width: 161px;"></td>
<td><input type="text" name="ko" value="" id="new_ko" placeholder=" 韓国語表記"        style="background-color: white; height: 26px; width: 161px;"></td>
</tr>
</table>
</div>
<div class="tableInner">
<table class="cTable">
<tr>
<th style="width: 30px;">使用</th>
<th style="width: 120px;">カテゴリ名</th>
<th style="width: 120px;">英語表記</th>
<th style="width: 120px;">簡体字表記</th>
<th style="width: 120px;">繁体字表記</th>
<th style="width: 120px;">韓国語表記</th>
<th style="width: 50px;">操作</th>
</tr>

<?php

  foreach ($category_data as $key => $value) {
      echo '<tr>';
      echo "<td><input type='checkbox' class='chgval' name='check[]' kbn='flg' ".$value['USE_FLG']." c='".$value['CATEGORY_ID']."' ></td>";
      echo "<td>"."<input type='text' class='chgval' name='ja' value = '".$value['JA_NAME']."' kbn='ja' c='".$value['CATEGORY_ID']."' >"."</td>";
      echo "<td>"."<input type='text' class='chgval' name='en' value = '".$value['EN_NAME']."' kbn='en' c='".$value['CATEGORY_ID']."' >"."</td>";
      echo "<td>"."<input type='text' class='chgval' name='ch' value = '".$value['CH_NAME']."' kbn='ch' c='".$value['CATEGORY_ID']."' >"."</td>";
      echo "<td>"."<input type='text' class='chgval' name='tw' value = '".$value['TW_NAME']."' kbn='tw' c='".$value['CATEGORY_ID']."' >"."</td>";
      echo "<td>"."<input type='text' class='chgval' name='ko' value = '".$value['KO_NAME']."' kbn='ko' c='".$value['CATEGORY_ID']."' >"."</td>";
      // echo "<td>".'<input type="button" name="edit" value="">'."</td>";
      echo "<td>";
      echo "<div class='edit'>";
      echo "<input type='button' name='edit'>";
      echo "<ul class='balloon'>";
      echo "<li><a>".Html::anchor('admin/plan/category_delete/'.$value['HTL_ID'].EXPLODE.$value['CATEGORY_ID'] ,'削除する')."</a></li>";
      echo "</ul>";
      echo "</div>";
      echo "</td>";
      echo '</tr>';
  }

?>

<input type="hidden" id="h" value="<?php echo $htl_id;?>">

</table>
</div>

</div>
</div>
</div>
<!-- /contents -->