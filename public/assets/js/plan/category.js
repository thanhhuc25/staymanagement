function add_category(){
    var htl_id  = $("#h").val();

    var ja_name = $("#new_ja").val();
    var en_name = $("#new_en").val();
    var ch_name = $("#new_ch").val();
    var tw_name = $("#new_tw").val();
    var ko_name = $("#new_ko").val();

    if (ja_name.length == 0) {return alert('日本語表記は必須です。');}
    // alert(htl_id);
    var data = {};
    data['htl_id'] = htl_id;
    data['ja'] = ja_name;
    data['en'] = en_name;
    data['ch'] = ch_name;
    data['tw'] = tw_name;
    data['ko'] = ko_name;

    // console.log(data);
    result = new_category(data);
    if (result == 'false' ) {return alert('カテゴリ登録に失敗しました。');}

    category_id = result;
    var htl_category = htl_id + "_" + category_id;

    $(".cTable").append(
     "<tr>"+
     "<td><input type='checkbox' class='chgval' kbn='flg' name='check[]' c='"+category_id+"' ></td>"+
     "<td>"+"<input type='text' class='chgval' name='ja' value = '"+ja_name+"' kbn='ja' c='"+category_id+"' >"+"</td>"+
     "<td>"+"<input type='text' class='chgval' name='en' value = '"+en_name+"' kbn='en' c='"+category_id+"' >"+"</td>"+
     "<td>"+"<input type='text' class='chgval' name='ch' value = '"+ch_name+"' kbn='ch' c='"+category_id+"' >"+"</td>"+
     "<td>"+"<input type='text' class='chgval' name='tw' value = '"+tw_name+"' kbn='tw' c='"+category_id+"' >"+"</td>"+
     "<td>"+"<input type='text' class='chgval' name='ko' value = '"+ko_name+"' kbn='ko' c='"+category_id+"' >"+"</td>"+
     "<td>"+
     "<div class='edit'>"+
     "<input type='button' name='edit'>"+
     "<ul class='balloon'>"+
     "<li><a herf='/admin/plan/category_delete/"+htl_category+"'>削除する</a></li>"+
     "</ul>"+
     "</div>"+
     "</td>"+
     "</tr>"
     );
    location.reload();
}
function new_category(data){
    var res = 'false';
    $.ajax({
        async : false,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/newCategory',
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
     var htl_id = $("#h").val();
     var category_id = $(this).attr("c");
     
     var kbn = $(this).attr("kbn");
     var val = $(this).val();

     if (kbn == 'flg') {
        if ($(this).prop('checked')) {
            val = '1';
        }else{
            val = '0';
        }
     }


     var data = {};
     data['htl_id'] = htl_id;
     data['category_id'] = category_id;
     data['kbn'] = kbn;
     data['val'] = val; 

    value_change(data);

    }));
   function value_change(data){
    $.ajax({
        async : true,
        type: 'POST',
        data: data,
        dataType: 'json',
        url : '/admin/api/chgvalCategory',
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
      // alert(XMLHttpRequest);
        }
    });
  }
});