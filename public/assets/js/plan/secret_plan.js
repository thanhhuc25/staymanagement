$(function () {

  $(".stop").on('click', function(){

    var this_obj = $(this);
    var data = {};


    data['htl_pln_id'] = $(this).attr('htl_pln_id');
    data['flg'] = '0';

    sale_change(data);
  });
  $(".onsale").on('click', function(){

    var this_obj = $(this);
    var data = {};

    data['htl_pln_id'] = $(this).attr('htl_pln_id');
    data['flg'] = 1;

    sale_change(data);
  });
 function sale_change(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/plan/secret_salechange',
        success : function(result) {
            if(result == 1){

              // window.confirm('通信成功');
            }
            else if(result == 0){

                // window.confirm('通信失敗');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
            $("#textStatus").html("textStatus : " + textStatus);
            $("#errorThrown").html("errorThrown : " + errorThrown.message);
            return false;
        }
    });
  }
  $(".sale_flg").on('change', function(){

    var this_obj = $(this);
    var data = {};

    data['htl_pln_id'] = $(this).attr('htl_pln_id');
    data['sort_val'] = $(this).val();

    sort_num_save(data);
  });
  function sort_num_save(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/plan/secret_sortchange',
        success : function(result) {
            if(result == 1){

              // window.confirm('通信成功');
            }
            else if(result == 0){

                // window.confirm('通信失敗');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#XMLHttpRequest").html("XMLHttpRequest : " + XMLHttpRequest.status);
            $("#textStatus").html("textStatus : " + textStatus);
            $("#errorThrown").html("errorThrown : " + errorThrown.message);
            return false;
        }
    });
  }
});

function new_plan(){
    location.href = "/admin/plan/new";
  }


function limit_change(){
    var limit = $('#limit').val();
    location.href = "/admin/plan/limit/" + limit;
}
function limit_change2(){
    var limit = $('#limit2').val();
    location.href = "/admin/plan/limit/" + limit;
}
