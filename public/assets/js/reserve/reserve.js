function resend(htl_rsv){
  if (window.confirm('メールを再送信しますか？')) {
  // // var data = $(this);
  // console.log(data);
  var data = {};
  data["htl_rsv"] = htl_rsv;
   $.ajax({
          async : true,
          type: 'POST',
          data: data,
          dataType: 'json',
          url : '/admin/api/resendMail',
          success : function(result) {
              // return result;
              if(result == 1){

                window.confirm('無効なメールアドレスです。');
              }
              else if(result == 0){

                  window.confirm('メールを再送信しました。');
              }
               else if(result == 2){

                  window.confirm('メールの送信に失敗しました。');
              }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert('Ajax通信に失敗しました。');
          }
      });
  }
}

$(function(){
  $(document).on("change", "#csvTerm01", (function(){
    var start = document.getElementById("csvTerm01").value;
    var end = document.getElementById("csvTerm02").value;




// alert(start);
  }));

  $(document).on("change", "#csvTerm02", (function(){
// alert('02');
  }));

});

function get_csv(htl_id){
  var start = document.getElementById("csvTerm01").value;
  var end = document.getElementById("csvTerm02").value;

  var reckon = $("[name=reckon]:checked").val();

  var get_value = '?start='+start+'&end='+end+'&type='+reckon+'&htl_id='+htl_id;
  // alert(get_value);

  location.href = '/admin/api/csv'+get_value;
}

function limit_change(){
    var limit = $('#limit').val();
    location.href = "/admin/reserve/limit/" + limit;
}
function limit_change2(){
    var limit = $('#limit2').val();
    location.href = "/admin/reserve/limit/" + limit;
}

function cancel(htl_rsv){
    if(window.confirm('キャンセルしますか？')){
      location.href = "/admin/reserve/cancel/" + htl_rsv;
    }
}
function chgcomeflg(htl_rsv_sts){
    if(window.confirm('来店状況を更新しますか？')){
      location.href = "/admin/reserve/chgcome/" + htl_rsv_sts;
    }
}