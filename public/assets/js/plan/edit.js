$(function () {
  
  if (document.getElementById("closingOut01").value) {
      $("#closingout").show();
    }else{
      $("#closingout").hide();
    }

  $("#closingOut01").change(function(){
    if (document.getElementById("closingOut01").value) {
      $("#closingout").show();
    }else{
      $("#closingout").hide();
    }
  });

  $("[name=closingOut2]").change(function(){
    if ($(this).val() == 0) {
      $("[name=closingOut]").empty();
      for (var i=24; i<=29; i++) {
        $("[name=closingOut]").append("<option value=\""+i+"\">"+i+"</option>");
      }
    } else {
      $("[name=closingOut]").empty();
      for (var i=0; i<=23; i++) {
        $("[name=closingOut]").append("<option value=\""+i+"\">"+i+"</option>");
      }
    }
  });

  $(document).on("click", ".chk_flg", (function(){
    $(this).parent('li').remove();
  }));

  $(document).on("click", "#addRoomType", (function(){
    var HtlTypeID = $("#selectedRoomType").val();
    var HtlPlnID = $("#HtlPlnID").val();
    var typename = $("#selectedRoomType option:selected").text();
    $('select#selectedRoomType option:selected').remove();

    var ids = HtlTypeID.split("_");
    var htlID = ids[0];
    var typeID = ids[1];
    ids = HtlPlnID.split("_");
    var plnID = ids[1];
    
    var data = {};

    data['htl_id'] = htlID;
    data['pln_id'] = plnID;
    data['type_id'] = typeID;

    minMax = new_plnrm(data);

    if (minMax == '0') {alert('error'); return;}
    mm = minMax.split("_");
    var min = mm[0];
    var max = mm[1];

    // var minArray = new Array('','','','','','','');
    // var maxArray = new Array('','','','','','','');

    // minArray[min] = 'selected';
    // maxArray[max] = 'selected';

    var optionMin = ""; 
    var optionMax = "";
    var personTitle = "";
    var personPay = "";

    for (var i = min; i <= max; i++) {
      if (i == min) {
        optionMin += "<option value='"+i+"' selected>"+i+"</option>";
      }else{
        optionMin += "<option value='"+i+"'>"+i+"</option>";
      }

      if (i == max) {
        optionMax += "<option value='"+i+"' selected>"+i+"</option>";
      }else{
        optionMax += "<option value='"+i+"'>"+i+"</option>";
      }

      personTitle += "<td>"+i+"名様</td>";
      personPay += "<td><input type='text' name='price"+i+"_"+typeID+"' id='price0101' value='0' class='chgval' >円/名</td>";
    }
    n = Math.floor(Math.random()*100);
    $(".sectionInner").append(
     "<div class='subSection'>"+
     "<div class='ttlBox clearfix'>"+
     "<h4>"+typename+"</h4><input type='hidden' name='rtype_id[]' value='"+typeID+"'>"+
     "<p class='btn'><input type='button' name='edit'><input type='button' class='roomType' htlplntype='"+htlID+"_"+plnID+"_"+typeID+"' name='delete'></p>"+
     "</div>"+
     "<div class='tableBox'>"+
     "<table>"+
     "<tr>"+
     "<th class='required'>定員</th>"+
     "<td class='range'>"+
     "<ul class='clearfix'>"+
     "<li><select name='capacityNumMin_"+typeID+"' id='capacityNum0101' class='chgval'>"+
     optionMin+
     "</select>名</li>"+
     "<li><span>～</span></li>"+
     "<li><select name='capacityNumMax_"+typeID+"' id='capacityNum0102' class='chgval'>"+
     optionMax+
     "</select>名</li>"+
     "</ul>"+
     "</td>"+
     "</tr>"+
     "<tr>"+
     "<th class='required'>基本大人料金</th>"+
     "<td class='basicPrice'>"+
     "<p class='attention'>※特定日を設定した状態で以下の料金を変更すると料金の整合性が取れなくなります。<br>変更後は必ず「料金管理」機能で特定日料金をご確認ください。</p>"+
     "<table>"+
     "<tr>"+
     personTitle+
     "</tr>"+
     "<tr>"+
     personPay+
     "</tr>"+
     "</table>"+
     "</td>"+
     "</tr>"+
     "<tr>"+
     "<th class='required'>子供料金</th>"+
     "<td class='childPrice'>"+
     "<table>"+
     "<tr>"+
     "<td>使用可否</td>"+
     "<td>料金・単位</td>"+
     "<td>人数換算</td>"+
     "</tr>"+
     "<tr>"+
     "<td><input type='checkbox' name='child1_"+typeID+"' id='child0101"+n+"' class='chgval' ><label for='child0101"+n+"' >小学生</label></td>"+
     "<td>"+
     "<input type='text' name='childprice1_"+typeID+"' value='0' id='childprice0101' class='chgval' >"+
     "<input type='radio' name='cal1_"+typeID+"' id='unit010101"+n+"' value='1' class='chgval' ><label for='unit010101"+n+"' >円</label>"+
     "<input type='radio' name='cal1_"+typeID+"' id='unit010102"+n+"' value='2' class='chgval' ><label for='unit010102"+n+"' >％</label>"+
     "<input type='radio' name='cal1_"+typeID+"' id='unit010103"+n+"' value='3' class='chgval' ><label for='unit010103"+n+"' >円引き</label>"+
     "</td>"+
     "<td><input type='checkbox' name='asadult1_"+typeID+"' id='asadult0101"+n+"' class='chgval' ><label for='asadult0101"+n+"'>大人として数える</label></td>"+
     "</tr>"+
     "<tr>"+
     "<td><input type='checkbox' name='child2_"+typeID+"' id='child0102"+n+"' class='chgval' ><label for='child0102"+n+"'>幼児（食事あり・寝具あり）</label></td>"+
     "<td>"+
     "<input type='text' name='childprice2_"+typeID+"' value='0' id='childprice0102' class='chgval'>"+
     "<input type='radio' name='cal2_"+typeID+"' id='unit010201"+n+"' value='1' class='chgval' ><label for='unit010201"+n+"'>円</label>"+
     "<input type='radio' name='cal2_"+typeID+"' id='unit010202"+n+"' value='2' class='chgval' ><label for='unit010202"+n+"'>％</label>"+
     "<input type='radio' name='cal2_"+typeID+"' id='unit010203"+n+"' value='3' class='chgval' ><label for='unit010203"+n+"'>円引き</label>"+
     "</td>"+
     "<td><input type='checkbox' name='asadult2_"+typeID+"' id='asadult0102"+n+"' class='chgval'  ><label for='asadult0102"+n+"'>大人として数える</label></td>"+
     "</tr>"+
     "<tr>"+
     "<td><input type='checkbox' name='child3_"+typeID+"' id='child0103"+n+"' class='chgval' ><label for='child0103"+n+"'>幼児（食事あり・寝具なし）</label></td>"+
     "<td>"+
     "<input type='text' name='childprice3_"+typeID+"' value='0' id='childprice0103' class='chgval' >"+
     "<input type='radio' name='cal3_"+typeID+"' id='unit010301"+n+"' value='1' class='chgval' ><label for='unit010301"+n+"'>円</label>"+
     "<input type='radio' name='cal3_"+typeID+"' id='unit010302"+n+"' value='2' class='chgval'  ><label for='unit010302"+n+"'>％</label>"+
     "<input type='radio' name='cal3_"+typeID+"' id='unit010303"+n+"' value='3' class='chgval' ><label for='unit010303"+n+"'>円引き</label>"+
     "</td>"+
     "<td><input type='checkbox' name='asadult3_"+typeID+"' id='asadult0103"+n+"' class='chgval' ><label for='asadult0103"+n+"'>大人として数える</label></td>"+
     "</tr>"+
     "<tr>"+
     "<td><input type='checkbox' name='child4_"+typeID+"' id='child0104"+n+"' class='chgval' ><label for='child0104"+n+"'>幼児（食事なし・寝具あり）</label></td>"+
     "<td>"+
     "<input type='text' name='childprice4_"+typeID+"' value='0' id='childprice0104' class='chgval'>"+
     "<input type='radio' name='cal4_"+typeID+"' id='unit010401"+n+"' value='1' class='chgval' ><label for='unit010401"+n+"'>円</label>"+
     "<input type='radio' name='cal4_"+typeID+"' id='unit010402"+n+"' value='2' class='chgval' ><label for='unit010402"+n+"'>％</label>"+
     "<input type='radio' name='cal4_"+typeID+"' id='unit010403"+n+"' value='3' class='chgval' ><label for='unit010403"+n+"'>円引き</label>"+
     "</td>"+
     "<td><input type='checkbox' name='asadult4_"+typeID+"' id='asadult0104"+n+"' class='chgval' ><label for='asadult0104"+n+"'>大人として数える</label></td>"+
     "</tr>"+
     "<tr>"+
     "<td><input type='checkbox' name='child5_"+typeID+"' id='child0105' class='chgval' ><label for='child0105'>幼児（食事なし・寝具なし）</label></td>"+
     "<td>"+
     "<input type='text' name='childprice5_"+typeID+"' value='0' id='childprice0105'  class='chgval'>"+
     "<input type='radio' name='cal5_"+typeID+"' id='unit010501"+n+"' value='1'  class='chgval' ><label for='unit010501"+n+"'>円</label>"+
     "<input type='radio' name='cal5_"+typeID+"' id='unit010502"+n+"' value='2'  class='chgval' ><label for='unit010502"+n+"'>％</label>"+
     "<input type='radio' name='cal5_"+typeID+"' id='unit010503"+n+"' value='3'  class='chgval' ><label for='unit010503"+n+"'>円引き</label>"+
     "</td>"+
     "<td><input type='checkbox' name='asadult5_"+typeID+"' id='asadult0105"+n+"' class='chgval' ><label for='asadult0105"+n+"'>大人として数える</label></td>"+
     "</tr>"+
     "<tr>"+
     "<td><input type='checkbox' name='child6_"+typeID+"' id='child0106"+n+"'  class='chgval'><label for='child0106"+n+"'>乳児（入館料）</label></td>"+
     "<td>"+
     "<input type='text' name='childprice6_"+typeID+"' value='0' id='childprice0106' class='chgval' >"+
     "<input type='radio'  name='cal6_"+typeID+"' id='unit010601"+n+"' value='1' class='chgval' ><label for='unit010601"+n+"'>円</label>"+
     "</td>"+
     "<td></td>"+
     "</tr>"+
     "</table>"+
     "</td>"+
     "</tr>"+
     "</table>"+
     "</div>"+
     "</div>"
     );

  }));
  
  $(document).on("click", ".roomType", (function(){
    HtlPlnTypeID = $(this).attr("htlplntype");
    var ids = HtlPlnTypeID.split("_");
    var HtlTypeID = ids[0] + "_" + ids[2];
    var name = $(this).parent('p').parent('div').children('h4').html();
    $("#selectedRoomType").append("<option value='" + HtlTypeID + "'>" + name + "</option>");
    $(this).parent('p').parent('div').parent('div').remove();

    var data = {};
    data['htl_pln_type_id'] = HtlPlnTypeID;
    delete_plnrm(data);
  }));
  function delete_plnrm(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/deletePlnRt',
        success : function(result) {
            // return result;
            // if(result == 1){

            //   window.confirm('通信成功');
            // }
            // else if(result == 0){

            //     window.confirm('通信失敗');
            // }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            // alert();
        }
    });
  }
  $("#timeAdd").on('click', function(){
    var checkinTime01 = $("#checkinTime01").val();
    var checkinTime02 = $("#checkinTime02").val();

    var num1 = Number(checkinTime01);
    var num2 = Number(checkinTime02);
    var str; var str2;

    if (num1 <= num2) {
      $(".timeSelect").empty();
      for (var i = num1; i <= num2; i++) {
          str = ''; str2 ='';
          str = ('0' + i).slice(-2);
          str2 = str;
          str += ':00';
          str2 += ':30';

          if ($("[name=checkinEvery]:checked").val() == 0) {
              $(".timeSelect").append("<li>"+str+"<a href='javascript:void(0);' class='chk_flg'><input type='hidden' name='c_times[]' value='"+str+"'></a></li>");
          }else if ($("[name=checkinEvery]:checked").val() == 1) {
              $(".timeSelect").append("<li>"+str+"<a href='javascript:void(0);' class='chk_flg'><input type='hidden' name='c_times[]' value='"+str+"'></a></li>");
              if (i != num2) {
                $(".timeSelect").append("<li>"+str2+"<a href='javascript:void(0);' class='chk_flg'><input type='hidden' name='c_times[]' value='"+str2+"'></a></li>");
              }
          }
      }
    }else{
      window.confirm('時間の選択が不適切です');
    }
  });
});
function new_plnrm(data){
    var res = '0';
    $.ajax({
        async : false,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/newPlnRt',
        success : function(result) {
          res = result;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
      // alert();
        }
    });
    return res;
  }


$(function(){
  $(document).on("change", ".chgval", (function(){
     var HtlPlnID = $("#HtlPlnID").val();
     var name = this.name; 
     var val;
     if (this.type == 'checkbox') {
        if (this.checked) {
          val = 1;
        }else{
          val = 0;
        }
     }else{
        val = $(this).val();
     }

      // $day=$(this).attr("day");
      var data = {};
      data['htl_pln_id'] = HtlPlnID;
      data['name'] = name;
      data['val'] = val;

      value_change(data);

    }));
});
 function value_change(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/chgvalPlnRt',
        success : function(result) {
            // return result;
            // if(result == 1){

            //   window.confirm('通信成功');
            // }
            // else if(result == 0){

            //     window.confirm('通信失敗');
            // }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
      // alert();
        }
    });
  }
$(function() {
     // ファイルの値が変わったら画像表示する
    $(".uploadHtlImg").change(function() {
      if ($(this).val() === '')  return false;

      var fileName = $(this).prop('files')[0].name;
      if (  $(this).attr('htlPlnId') == '1_1_1') {
        $(this).prop('files')[0].name = '1_1_1';
        // alert('1');
      }
      if (  $(this).attr('htlPlnId') == '1_1_2') {
        $(this).prop('files')[0].name = '1_1_2';
        // alert('2');
      }
      if (  $(this).attr('htlPlnId') == '1_1_3') {
        $(this).prop('files')[0].name = '1_1_3';
        // alert('3');
      }


    });
});

function delete_plan(){
  if (window.confirm('削除しますか？')) {location.href = "/admin/plan/delete/"+$("#HtlPlnID").val();}
}
