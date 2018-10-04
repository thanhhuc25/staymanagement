/* ------------------------------------------------------------------

 common.js
	
------------------------------------------------------------------ */

// var dateFormat = 'yy-mm-dd';
// $("#datepicker1").datepicker({dateFormat: dateFormat});

//pc版とsp版の画像切り替え
$(function(){

	var setFlug = window.innerWidth;
	imgSet(setFlug);

	
	function imgSet(setFlug) {
		if(setFlug>768){
		$(".imgSet img").each(function(index){
		if ($(this).attr("src")){
		$(this).attr("src",$(this).attr("src").replace(/^(.+)_sp(\.[a-z]+)$/, "$1$2"));
		}
		});
		}else{
		$(".imgSet img").each(function(index){
		if ($(this).attr("src").indexOf('_sp')<0){
		$(this).attr("src",$(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_sp$2"));
		}
		});
		}
	}
});

//
//header
//

$(function(){
	$(".spMenu").click(function(){
		$('.spGnav').slideToggle();
	});
});

$(function() {
	function heightFix() {
		$('header').each(function(){
			var Height = $(this).innerHeight();
			$('#contents').css({'padding-top':Height});
		});
	}
	$(function() {
		heightFix();
	});
	$(window).on('resize', function(){
		heightFix();
	});
});

//
//datepicker
//

$(function() {
	var html = document.getElementsByTagName("html");
  var lang = html[0]['lang'];
  var format = 'yy/m/d';
  if (lang == 'ja') {
  	format = 'yy年m月d日';
  }
	if($.datepicker){
		// 2日本語を有効化
		$.datepicker.setDefaults($.datepicker.regional['ja']);
		// 3日付選択ボックスを生成
		$('#ciDateYMD').datepicker({ 
			changeYear: true,
			changeMonth: true,
			yearRange: "-100:+1",
			dateFormat: format
		});
	}
});

//
//colorbox
//

$(window).on('load resize', function(){
	$(".colorbox").each(function() {
		var width = $(window).innerWidth();
		if(width <= 768){
			$(function(){
				$(".colorbox").colorbox({
					opacity: 0.7,
					inline: true,
					current: false,
					title: false,
					width: true,
					maxWidth: '94%'
				});
			});
		} else {
			$(function(){
				$(".colorbox").colorbox({
					opacity: 0.7,
					inline: true,
					current: false,
					title: false,
					width: true,
					initialWidth: "940"
				});
			});
		}
	});
});

//
//bxslider
//

$(window).on('load', function(){
	$('.roomFrame').each(function(){
		$('.roomFrame > ul').bxSlider({
			auto: false,
			speed: 500,
			pager: true,
			controls: true
		});
	});
});

$(window).on('load resize', function(e){
	console.log(e.type);
	var winWidth = $(window).width();
	var Width = $('.roomFrame').width();
	if (window.innerWidth <= 768){
		$('.roomFrame ul li img').css({'width':'100%'});
		$('.roomFrame ul li').css({'width':winWidth * 0.94});
		$('.roomFrame ul li').css({'height':winWidth * 0.6758 * 0.94});
		//$('.roomFrame ul li').css({'height':winWidth * 0.94});
	} else {
		$('.roomFrame ul li img').css({'width':'100%'});
		$('.roomFrame ul li').css({'width':Width});
		$('.roomFrame ul li').css({'height':Width * 0.6758});
		//$('.roomFrame ul li').each(function() {
			//$(this).css({'height':$(this).find('img').height()});
		//});
	}
});

$(window).on('load', function(){
	$('.roomImg .imgSlide').each(function(){
		$(this).bxSlider({
			auto: false,
			speed: 500,
			pagerCustom: '.roomImg .imgThumb',
            adaptiveHeight: true,
			controls: false
		});
	});
});

	//ページ内リンク
$(function(){
	$('.anc a , .pagetop a').click(function() {
		var winWidth = window.innerWidth;

			var speed = 400;
			var href= $(this).attr("href");
			var target = $(href == "#" || href == "" ? 'html' : href);
			var position = target.offset().top;
			$('body,html').animate({scrollTop:position}, speed, 'swing');
			return false;

	});
});
