function nextMonth(){
    var htl_pln_id = $("#HtlPlnID").val();
    var date =  $("#PlnDate").val();
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

    var url = '/admin/price/price/';
    url += htl_pln_id +sl+ year;
    location.href = url;
}

function preMonth(){
    var htl_pln_id = $("#HtlPlnID").val();
    var date =  $("#PlnDate").val();
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

    var url = '/admin/price/price/';
    url += htl_pln_id +sl+ year;
    location.href = url;
}


function showPrice(){

    var htl_pln_id = $("[name=planType]").val();
    var year = $("[name=planYear]").val();
    var month = $("[name=planMonth]").val();

    var url = '/admin/price/price/';
    var sl = '/';
    var sl2 = '_';
    url += htl_pln_id + sl + year + sl2 + month;
    location.href = url;
}


$(function(){
  $(document).on("change", ".chgval", (function(){
     var HtlPlnID = $("#HtlPlnID").val();
     var typeID = $(this).attr("t_id");
     var year = $("[name=planYear]").val();
     var month = $("[name=planMonth]").val();
     var day = $(this).attr("day");
     var date = year+'-'+month+'-'+day;
     var n = $(this).attr("n");
     var val = $(this).val();

     var data = {};
     data['htl_pln_type_id'] = HtlPlnID+'_'+typeID;
     data['date'] = date;
     data['num'] = n;
     data['val'] = val; 

    value_change(data);

    }));
   function value_change(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/chgvalPlnExday',
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
});