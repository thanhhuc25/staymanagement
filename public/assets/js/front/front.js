function cancel(htl){
  var html = document.getElementsByTagName("html");
  var lang = html[0]['lang'];
  var word = 'Do you want to cancel this reserve ?';
  if (lang == 'ja') {
    word = 'キャンセルしますか？';
  }

    if(window.confirm(word)){
        location.href = "/" + htl + "/reserve/cancel";
    }
}
$(function () {
$( 'input[name="changepasswd"]:radio' ).change( function() {  
if ($(this).val() == 1) {
   $(".chgpass").show();
}else{
   $(".chgpass").hide();
}
});  
});