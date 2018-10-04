$(function () {
  // var dateFormat = 'yy-mm-dd';
  // $("#datepicker").datepicker({dateFormat: dateFormat});
  // $("#datepicker2").datepicker({dateFormat: dateFormat});
  // $("#datepicker3").datepicker({dateFormat: dateFormat});
  // $("#datepicker4").datepicker({dateFormat: dateFormat});



});
function delete_room(){
  if (window.confirm('削除しまか？')) {
     location.href = "/admin/room/delete/"+$("#HtlTypeID").val();
  }else{

  }
}