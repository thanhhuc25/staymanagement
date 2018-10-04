/* ------------------------------------------------------------------

 common.js
	
------------------------------------------------------------------ */

//
//datepicker
//

$(function() {
	if($.datepicker){
		// 2日本語を有効化
		$.datepicker.setDefaults($.datepicker.regional['ja']);
		// 3日付選択ボックスを生成
		$('#saleTerm01,#saleTerm02,#showTerm01,#showTerm02').datepicker({ 
			changeYear: true,
			changeMonth: true,
			dateFormat: 'yy-mm-dd'
		});
	}
});

//
//edit
//

$(function() {
	$('td .edit input[name="editAll"],td .edit input[name="edit"]').click(function () {
		$('.balloon').hide();
		$(this).next('.balloon').toggle();
	});
	$(function() {
		$('td .edit input[name="editAll"],td .edit input[name="edit"]').click(function(e) {
			e.stopPropagation();
		});
		$(document).click(function() {
			$('.balloon').hide();
		});
	});
});

//
//checkAll,removeAll
//

$(function() {
	$('input[name="check"],input[name="checkAll"],input[name="removeAll"]').each(function(){
		$('input[name="checkAll"]').click(function () {
			$('input[name="check[]"]').prop("checked",true);
		});
		$('input[name="removeAll"]').click(function () {
			$('input[name="check[]"]').prop("checked",false);
		});
	});
});

//
//timeSelect
//

$(function() {
	$('.timeSelect').each(function(){
		$('.timeSelect li a').click(function () {
			$(this).parent('li').remove();
		});
		$('input[name="timeDelete"]').click(function () {
			$('.timeSelect li').remove();
		});
	});
});

//
//editInner
//

$(function() {
	$('.editTab,.editInner').each(function(){
		$('.editTab li:first').addClass('current');
		$('.editInner .section').hide();
		$('.editInner .section:first').show();
		
		$('.editTab li').click(function () {
			$('.editTab li').removeClass('current');
			$(this).addClass('current');
			$('.editInner .section').hide();
			$('.editInner .section').eq($('.editTab li').index(this)).show();
		});
	});
});

//
//sectionInner
//

$(function() {
	$('.sectionInner').each(function(){
		$('.sectionInner .subSection .tableBox').hide();
		$('.sectionInner .subSection:first .tableBox').show();
		
		$('.sectionInner .subSection .ttlBox input[name="edit"]').click(function () {
			$(this).parents('.ttlBox').next('.tableBox').toggle();
		});
	});
});

//
//explan
//

$(function() {
	$('.editInner .explan').each(function(){
		$('.editInner .explan .txtBox:first .txt').addClass('active');
		$('.editInner .explan .txtBox .input').hide();
		$('.editInner .explan .txtBox:first .input').show();
		
		$('.editInner .explan .txtBox .txt').click(function () {
			$(this).toggleClass('active');
			$(this).next('.input').toggle();
		});
	});
});

//
//tablePlan
//

$(function() {
	$('.tablePlan').each(function(){
		var n = $('.tablePlan tr:first td').length;
		$('.tablePlan table').css('width', 249 + 114 * n);
	});
});
