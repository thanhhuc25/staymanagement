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
		// 宿泊プランの編集
		$('#saleTerm01,#saleTerm02,#showTerm01,#showTerm02').datepicker({ 
			changeYear: true,
			changeMonth: true,
			dateFormat: 'yy/mm/dd'
		});
		// 予約管理
		$('#checkinTime02,#checkinTime03,#checkoutTime02,#checkoutTime03').datepicker({ 
			changeYear: true,
			changeMonth: true,
			dateFormat: 'yy/mm/dd'
		});
		// 予約CSV出力
		$('#csvTerm01,#csvTerm02').datepicker({ 
			changeYear: true,
			changeMonth: true,
			dateFormat: 'yy/mm/dd'
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
	$('input[name="check[]"],input[name="checkAll"],input[name="removeAll"]').each(function(){
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

//
//basicPrice
//

// $(function() {
// 	$('select#capacityNum0102').change(function() {
// 		if ($('select#capacityNum0102').val()=='1') {
// 			$('input#price0101').prop('disabled', false);
// 			$('input#price0102').prop('disabled', true);
// 			$('input#price0103').prop('disabled', true);
// 			$('input#price0104').prop('disabled', true);
// 			$('input#price0105').prop('disabled', true);
// 			$('input#price0106').prop('disabled', true);
// 		}
// 		if ($('select#capacityNum0102').val()=='2') {
// 			$('input#price0101').prop('disabled', false);
// 			$('input#price0102').prop('disabled', false);
// 			$('input#price0103').prop('disabled', true);
// 			$('input#price0104').prop('disabled', true);
// 			$('input#price0105').prop('disabled', true);
// 			$('input#price0106').prop('disabled', true);
// 		}
// 		if ($('select#capacityNum0102').val()=='3') {
// 			$('input#price0101').prop('disabled', false);
// 			$('input#price0102').prop('disabled', false);
// 			$('input#price0103').prop('disabled', false);
// 			$('input#price0104').prop('disabled', true);
// 			$('input#price0105').prop('disabled', true);
// 			$('input#price0106').prop('disabled', true);
// 		}
// 		if ($('select#capacityNum0102').val()=='4') {
// 			$('input#price0101').prop('disabled', false);
// 			$('input#price0102').prop('disabled', false);
// 			$('input#price0103').prop('disabled', false);
// 			$('input#price0104').prop('disabled', false);
// 			$('input#price0105').prop('disabled', true);
// 			$('input#price0106').prop('disabled', true);
// 		}
// 		if ($('select#capacityNum0102').val()=='5') {
// 			$('input#price0101').prop('disabled', false);
// 			$('input#price0102').prop('disabled', false);
// 			$('input#price0103').prop('disabled', false);
// 			$('input#price0104').prop('disabled', false);
// 			$('input#price0105').prop('disabled', false);
// 			$('input#price0106').prop('disabled', true);
// 		}
// 		if ($('select#capacityNum0102').val()=='6') {
// 			$('input#price0101').prop('disabled', false);
// 			$('input#price0102').prop('disabled', false);
// 			$('input#price0103').prop('disabled', false);
// 			$('input#price0104').prop('disabled', false);
// 			$('input#price0105').prop('disabled', false);
// 			$('input#price0106').prop('disabled', false);
// 		}
// 	});
// });

//
//childPrice
//

// $(function() {
// 	$('input[name=child]').change(function() {
// 		if ($('input#child0101').prop('checked')) {
// 			$('input#childprice0101').prop('disabled', false);
// 			$('input[name=unit0101]').prop('disabled', false);
// 			$('input#asadult0101').prop('disabled', false);
// 		} else {
// 			$('input#childprice0101').prop('disabled', true);
// 			$('input[name=unit0101]').prop('disabled', true);
// 			$('input#asadult0101').prop('disabled', true);
// 		}
// 		if ($('input#child0102').prop('checked')) {
// 			$('input#childprice0102').prop('disabled', false);
// 			$('input[name=unit0102]').prop('disabled', false);
// 			$('input#asadult0102').prop('disabled', false);
// 		} else {
// 			$('input#childprice0102').prop('disabled', true);
// 			$('input[name=unit0102]').prop('disabled', true);
// 			$('input#asadult0102').prop('disabled', true);
// 		}
// 		if ($('input#child0103').prop('checked')) {
// 			$('input#childprice0103').prop('disabled', false);
// 			$('input[name=unit0103]').prop('disabled', false);
// 			$('input#asadult0103').prop('disabled', false);
// 		} else {
// 			$('input#childprice0103').prop('disabled', true);
// 			$('input[name=unit0103]').prop('disabled', true);
// 			$('input#asadult0103').prop('disabled', true);
// 		}
// 		if ($('input#child0104').prop('checked')) {
// 			$('input#childprice0104').prop('disabled', false);
// 			$('input[name=unit0104]').prop('disabled', false);
// 			$('input#asadult0104').prop('disabled', false);
// 		} else {
// 			$('input#childprice0104').prop('disabled', true);
// 			$('input[name=unit0104]').prop('disabled', true);
// 			$('input#asadult0104').prop('disabled', true);
// 		}
// 		if ($('input#child0105').prop('checked')) {
// 			$('input#childprice0105').prop('disabled', false);
// 			$('input[name=unit0105]').prop('disabled', false);
// 			$('input#asadult0105').prop('disabled', false);
// 		} else {
// 			$('input#childprice0105').prop('disabled', true);
// 			$('input[name=unit0105]').prop('disabled', true);
// 			$('input#asadult0105').prop('disabled', true);
// 		}
// 		if ($('input#child0106').prop('checked')) {
// 			$('input#childprice0106').prop('disabled', false);
// 			$('input[name=unit0106]').prop('disabled', false);
// 		} else {
// 			$('input#childprice0106').prop('disabled', true);
// 			$('input[name=unit0106]').prop('disabled', true);
// 		}
// 	});
// });

