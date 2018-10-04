$(function () {  
  //テキストボックスに変更を加えたら発動
  $("#ciDateYMD").change(function() {
  var html = document.getElementsByTagName("html");
  var lang = html[0]['lang'];


  var date = $(this).val();
  var flg = 0;

  if (date.length == 0) {
    return;
  } else {
    $('#ciDateU').prop('checked', false);
  }

  var error = 'Please enter the correct date.';
  if (lang == 'ja') {
    error = '日付の入力が不正です。';
    if ( date.match(/年/)) {
        date = date.replace("年",".");
    }else{
        flg = 1;
    }

    if ( date.match(/月/)) {
        date = date.replace("月",".");
    }else{
        flg = 1;
    }

    if ( date.match(/日/)) {
        date = date.replace("日","");
    }else{
        flg = 1;
    }

    if (flg == 1) {
      document.getElementById( "ciDateYMD" ).value = "";
      return alert(error);
    }
  }else{
    date = date.replace(/[\/]/g,".");
  }


  var dates = date.split(".");

  var year = dates[0];
  var month = dates[1];
  var day = dates[2];


  dt=new Date(year,month-1,day);
  if (dt.getFullYear()==year && dt.getMonth()==month-1 && dt.getDate()==day){
      //何もしない
  }else{
    document.getElementById( "ciDateYMD" ).value = "";
    return alert(error);
  }

  });

  $('#ciDateU').on('change', function(){
    if ($(this).prop('checked')) {
      $("#ciDateYMD").val('');
    }
  });

});