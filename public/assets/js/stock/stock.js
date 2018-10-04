function nextMonth(){
    var htl_pln_id = $("#HtlTypeID").val();
    var date =  $("#selectedDate").val();
    var dates = date.split('_');
    var month = Number(dates[1]);
    var year = Number(dates[0]);
    if (dates[1] == '12') {
        year += 1;
        month = 1;
    }else{
        month += 1;
    }
 
    year += '';
    var sl2 = '_';
    var sl = '/';
    year += sl2;
    month += '';
    year += month;

    var url = '/admin/stock/stock/';
    url += htl_pln_id +sl+ year;
    location.href = url;
}

function preMonth(){
    var htl_pln_id = $("#HtlTypeID").val();
    var date =  $("#selectedDate").val();
    var dates = date.split('_');
    var month = Number(dates[1]);
    var year = Number(dates[0]);
    if (dates[1] == '1') {
        year -= 1;
        month = 12;
    }else{
        month -= 1;
    }
 
    year += '';
    var sl2 = '_';
    var sl = '/';
    year += sl2;
    month += '';
    year += month;

    var url = '/admin/stock/stock/';
    url += htl_pln_id +sl+ year;
    location.href = url;
}


function showStock(){

    var htl_pln_id = $("[name=roomType]").val();
    var year = $("[name=roomYear]").val();
    var month = $("[name=roomMonth]").val();

    var url = '/admin/stock/stock/';
    var sl = '/';
    var sl2 = '_';
    url += htl_pln_id + sl + year + sl2 + month;
    location.href = url;
}

$(function () {
$(document).on("click", ".onsale", (function(){
    if (isset($(this).attr("htl_pln_id"))) {
        var this_obj = $(this);
        var data = {};

        data['htl_pln_id'] = $(this).attr('htl_pln_id');
        data['flg'] = 0;


         location.href = "/admin/stock/chgsale/"+$(this).attr('htl_pln_id')+'/1';

        // var elements = document.getElementsByClassName( "yokoflg_"+ $(this).attr("htl_pln_id")) ;
        // $.each(elements, function(key,element) {
        //     $(element).children('ul').children('li').removeClass('onsale');
        //     $(element).children('ul').children('li').addClass('stop');
        //     $(element).children('ul').children('li').html("停止");
        // });

        // $(this).removeClass('onsale');
        // $(this).addClass('stop');
        // $(this).html("停止");


        // sale_change(data);
    }else if (isset($(this).attr("day")) && isset($(this).attr("p")) ){
        $day=$(this).attr("day");
        var data = {};

        data['htl_type_id'] = $("#HtlTypeID").val();
        data['pln_id'] = $(this).attr("p");
        data['date'] = $("#selectedDate").val() ;
        data['day']=$day;
        data['flg'] = 0;
        sale_change(data);

        $(this).removeClass('onsale');
        $(this).addClass('stop');
        $(this).html("停止する");

        // location.href = "/stock/chgdaysale/"+ $("#HtlTypeID").val() + "/" + $("#selectedDate").val() + "/" + $(this).attr("day") + "/0";

    }else if (isset($(this).attr("day"))){
        // $day=$(this).attr("day");
        // var data = {};

        // data['htl_type_id'] = $("#HtlTypeID").val();
        // data['day']=$day;
        // data['flg'] = 1;

        location.href = "/admin/stock/chgdaysale/"+ $("#HtlTypeID").val() + "/" + $("#selectedDate").val() + "/" + $(this).attr("day") + "/0";

    }else{return false;}
  }));
$(document).on("click", ".stop", (function(){
    if (isset($(this).attr("htl_pln_id"))) {
        var this_obj = $(this);
        var data = {};

        data['htl_pln_id'] = $(this).attr('htl_pln_id');
        data['flg'] = 1;
        location.href = "/admin/stock/chgsale/"+$(this).attr('htl_pln_id')+'/0';
        //  var elements = document.getElementsByClassName( "yokoflg_"+ $(this).attr("htl_pln_id")) ;
        // $.each(elements, function(key,element) {
        //     $(element).children('ul').children('li').removeClass('stop');
        //     $(element).children('ul').children('li').addClass('onsale');
        //     $(element).children('ul').children('li').html("販売");
        // });

        // $(this).removeClass('stop');
        // $(this).addClass('onsale');
        // $(this).html("販売");



        // sale_change(data);
    }else if (isset($(this).attr("day")) && isset($(this).attr("p")) ){
        $day=$(this).attr("day");
        var data = {};

        data['htl_type_id'] = $("#HtlTypeID").val();
        data['pln_id'] = $(this).attr("p");
        data['date'] = $("#selectedDate").val() ;
        data['day']=$day;
        data['flg'] = 1;
        sale_change(data);

        $(this).removeClass('stop');
        $(this).addClass('onsale');
        $(this).html("販売する");

        // location.href = "/admin/stock/chgdaysale/"+ $("#HtlTypeID").val() + "/" + $("#selectedDate").val() + "/" + $(this).attr("day") + "/0";

    }else if (isset($(this).attr("day"))){
       location.href = "/admin/stock/chgdaysale/"+ $("#HtlTypeID").val() + "/" + $("#selectedDate").val() + "/" + $(this).attr("day") + "/1";

    }else{return false;}
  }));
 function sale_change(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/chgdayplnsale',
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
  //テキストボックスに変更を加えたら発動
  $('input[type="text"]').change(function() {
 
    var val = $(this).val();
    var data = {};
    day=$(this).attr("d");

    totalrmnum = $("#totalrmnum").html();

    data['htl_type_id'] = $("#HtlTypeID").val();
    data['date'] = $("#selectedDate").val() ;
    data['day']= day;
    data['saledval'] = $(this).attr("s");
    data['editval'] = val;
    data['rmnum'] = totalrmnum.replace("室", "" ) ;

    num_change(data);
  });
   function num_change(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/numchange',
        success : function(result) {
            if(result == 1){

              // window.confirm('通信成功');
            }
            else if(result == 0){

                window.confirm('整数を入力してください');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        }
    });
  }
  /**
   *  値の有無をチェック
   *  phpのisset()に相当
   *  
   *  @param  data    値
   *  @return         true / false
   *
   */
  var isset = function(data){
      if(data === "" || data === null || data === undefined){
          return false;
      }else{
          return true;
      }
  };
});