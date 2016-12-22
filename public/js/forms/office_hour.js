var OfficeHour = {
	panel: '_office_time',
	sameTime: false,
	code: null,
	index: 1,
	days: ['วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์','วันอาทิตย์']
}

OfficeHour.load = function(officeHours) {

	OfficeHour.init();
	OfficeHour.bind();

	if (typeof officeHours != 'undefined') {
		var _officeHours = JSON.parse(officeHours);

		var selects = ['_start_hour','_start_min','_end_hour','_end_min'];

		for (var i = 1; i <= Object.keys(_officeHours).length; i++) {

			if(_officeHours[i]['open']){
				$('#'+i+'_open').prop('checked','checked');

				$('#'+i+'_start_hour').val(_officeHours[i]['start_time']['hour']);
				$('#'+i+'_start_min').val(_officeHours[i]['start_time']['min']);
				$('#'+i+'_end_hour').val(_officeHours[i]['end_time']['hour']);
				$('#'+i+'_end_min').val(_officeHours[i]['end_time']['min']);
			}

		}
	}

	$('.office-switch-btn').each(function(key, value) {
		OfficeHour.disabled(value,$(value).parent());
	});

}

OfficeHour.init = function() {
	OfficeHour.code = OfficeHour.generateCode();

	for (var i = 0; i < OfficeHour.days.length; i++) {
		OfficeHour.index = OfficeHour.createSelect(OfficeHour.days[i],OfficeHour.index,OfficeHour.code);
	}

}

OfficeHour.bind = function() {

	$('#same_time').on('click',function(){
		if($(this).is(':checked')){
			OfficeHour.sameTime = true;
			OfficeHour.setSameTime();
		}else{
			OfficeHour.sameTime = false;
		}
	});

	// $('select[name^="OfficeHour"]').on('change',function(){
	// 	if(OfficeHour.sameTime){
	// 		OfficeHour.setTime($(this).prop('id'),$(this).val());
	// 	}
	// });

	$('.'+OfficeHour.code+'-office-switch-btn').on('change',function(){
		OfficeHour.disabled(this,$(this).parent());
	});

	$('select[id^="'+OfficeHour.code+'"]').on('change',function(){
		alert('xxxx');
	});

}

OfficeHour.disabled = function(obj,parent) {
	if(!$(obj).find('input[type="checkbox"]').is(':checked')){
		parent.find('select').val(0).prop('disabled','disabled').addClass('disabled');
		parent.find('.office-status').removeClass('active');
	}else{

		parent.find('select').removeAttr('disabled').removeClass('disabled');
		parent.find('.office-status').addClass('active');

		if(OfficeHour.sameTime){	
			OfficeHour.setSameTime();
		}

	}
}

OfficeHour.setSameTime = function() {
	var selects = ['1_start_hour','1_start_min','1_end_hour','1_end_min'];

	for (var i = 0; i < selects.length; i++) {	
		OfficeHour.setTime(selects[i],$('#'+selects[i]).val());			
	};
}

OfficeHour.setTime = function(id,value) {
	var parts = id.split('_');

	for (var i = 1; i <= 7; i++) {
		if(!$('#'+i+'_'+parts[1]+'_'+parts[2]).prop('disabled')){
			$('#'+i+'_'+parts[1]+'_'+parts[2]).val(value);
		}
	}
}

OfficeHour.createSelect = function(day,index,code) {

	var html = '';
	html += '<div id="'+code+'_'+index+'" class="form-row">';
	html += '<label for="OfficeHour['+index+']">'+day+'</label> ';             
	html += '<label class="switch '+code+'-office-switch-btn">';
	html += '<input id="'+code+'_'+index+'_open" type="checkbox" name="OfficeHour['+index+'][open]" value="1" checked>';
	html += '<div class="slider round office-hour"></div>';
	html += '</label>';
	html += '<select id="'+code+'_'+index+'_start_hour" name="OfficeHour['+index+'][start_time][hour]">{{hour}}</select>';
	html += '<select id="'+code+'_'+index+'_start_min" name="OfficeHour['+index+'][start_time][min]">{{min}}</select>';
	html += '<select id="'+code+'_'+index+'_end_hour" name="OfficeHour['+index+'][end_time][hour]">{{hour}}</select>';
	html += '<select id="'+code+'_'+index+'_end_min" name="OfficeHour['+index+'][end_time][min]">{{min}}</select>';
	html += '<div id="'+code+'_'+index+'_status" class="office-status active"></div>';
	html += '</div>';

	$('#'+OfficeHour.panel).append(html);
console.log($('#'+code+'_'+index+'_end_min'));
	$('#'+code+'_'+index+'_end_min').append(OfficeHour.optionHours());

	return ++index;
}

OfficeHour.optionHours = function() {

	var hour = '';
	for (var i = 0; i < 24; i++) {
		var option = document.createElement('option'); 
		option.value = i;
		option.innerHTML = i;
		hour += option;
	};

	return hour;
}

OfficeHour.optionMins = function() {

	var min = '';
	for (var i = 0; i < 60; i++) {
		var option = document.createElement('option'); 
		option.value = i;
		option.innerHTML = i;
		min += option;
	};

	return min;
}

OfficeHour.generateCode = function() {
	var codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  codeAlphabet += "abcdefghijklmnopqrstuvwxyz";
  codeAlphabet += "0123456789";

  var code = '';
  var len = codeAlphabet.length;

  for (var i = 0; i <= 7; i++) {
  	code += codeAlphabet[Math.floor(Math.random() * (len - 0) + 0)];
  };

	return code;
}