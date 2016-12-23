var OfficeHour = {
	panel: '_office_time',
	sameTime: false,
	code: null,
	index: 1,
	days: ['วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์','วันอาทิตย์'],
	latestStartHour: 0,
	latestStartMin: 0,
	latestEndHour: 0,
	latestEndMin: 0
}

OfficeHour.load = function(officeHours,sameTime) {

	OfficeHour.init();
	OfficeHour.bind();

	if (typeof sameTime != 'undefined') {
		OfficeHour.sameTime = sameTime;
	}

	if (typeof officeHours != 'undefined') {
		var _officeHours = JSON.parse(officeHours);

		var selects = ['_start_hour','_start_min','_end_hour','_end_min'];

		for (var i = 1; i <= Object.keys(_officeHours).length; i++) {

			if(_officeHours[i]['open']){
				$('#'+OfficeHour.code+'_'+i+'_open').prop('checked','checked');

				OfficeHour.latestStartHour = _officeHours[i]['start_time']['hour'];
				OfficeHour.latestStartMin = _officeHours[i]['start_time']['min'];
				OfficeHour.latestEndHour = _officeHours[i]['end_time']['hour'];
				OfficeHour.latestEndMin = _officeHours[i]['end_time']['min'];

				$('#'+OfficeHour.code+'_'+i+'_start_hour').val(_officeHours[i]['start_time']['hour']);
				$('#'+OfficeHour.code+'_'+i+'_start_min').val(_officeHours[i]['start_time']['min']);
				$('#'+OfficeHour.code+'_'+i+'_end_hour').val(_officeHours[i]['end_time']['hour']);
				$('#'+OfficeHour.code+'_'+i+'_end_min').val(_officeHours[i]['end_time']['min']);
			}else{
				var obj = $('#'+OfficeHour.code+'_'+i+'_switch');
				OfficeHour.disabled(obj,obj.parent());
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

	$('#office_hour_same_time').on('click',function(){
		if($(this).is(':checked')){
			OfficeHour.sameTime = true;
			OfficeHour.setSameTime(OfficeHour.code);
		}else{
			OfficeHour.sameTime = false;
		}
	});

	$('.'+OfficeHour.code+'-office-switch-btn').on('change',function(){
		OfficeHour.disabled(this,$(this).parent());
	});

	$('select[id^="'+OfficeHour.code+'"]').on('change',function(){
		
		var id =$(this).prop('id');
		var parts = id.split('_');

		OfficeHour.setLatestValue(parts[2],parts[3],$(this).val());

		if(OfficeHour.sameTime){
			OfficeHour.setTimes($(this).prop('id'),$(this).val(),OfficeHour.code);
		}
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
			parent.find('select').each(function(key, value) {
				var id = $(this).prop('id');
				var parts = id.split('_');
				var value = OfficeHour.getLatestValue(parts[2],parts[3]);

				$(this).val(value);
			});
		}

	}
}

OfficeHour.setSameTime = function(code) {
	var selects = [code+'_'+'1_start_hour',code+'_'+'1_start_min',code+'_'+'1_end_hour',code+'_'+'1_end_min'];

	for (var i = 0; i < selects.length; i++) {

		var id = $('#'+selects[i]).prop('id');
		var parts = id.split('_');
		var value = OfficeHour.getLatestValue(parts[2],parts[3]);

		OfficeHour.setTimes(selects[i],value,code);			
	};
}

OfficeHour.setTimes = function(id,value,code) {
	var parts = id.split('_');

	for (var i = 1; i <= 7; i++) {
		if(!$('#'+code+'_'+i+'_'+parts[2]+'_'+parts[3]).prop('disabled')){
			$('#'+code+'_'+i+'_'+parts[2]+'_'+parts[3]).val(value);
		}
	}
}

OfficeHour.createSelect = function(day,index,code) {

	var html = '';
	html += '<div id="'+code+'_'+index+'" class="form-row">';
	html += '<label for="OfficeHour['+index+']">'+day+'</label> ';             
	html += '<label id="'+code+'_'+index+'_switch" class="switch '+code+'-office-switch-btn">';
	html += '<input id="'+code+'_'+index+'_open" type="checkbox" name="OfficeHour['+index+'][open]" value="1">';
	html += '<div class="slider round office-hour"></div>';
	html += '</label>';
	html += '<select id="'+code+'_'+index+'_start_hour" name="OfficeHour['+index+'][start_time][hour]"></select>';
	html += '<b> : </b>';
	html += '<select id="'+code+'_'+index+'_start_min" name="OfficeHour['+index+'][start_time][min]"></select>';
	html += '<b> - </b>';
	html += '<select id="'+code+'_'+index+'_end_hour" name="OfficeHour['+index+'][end_time][hour]"></select>';
	html += '<b> : </b>';
	html += '<select id="'+code+'_'+index+'_end_min" name="OfficeHour['+index+'][end_time][min]"></select>';
	html += '<div id="'+code+'_'+index+'_status" class="office-status active"></div>';
	html += '</div>';

	$('#'+OfficeHour.panel).append(html);

	$('#'+code+'_'+index+'_start_hour').append(OfficeHour.optionHours());
	$('#'+code+'_'+index+'_start_min').append(OfficeHour.optionMins());
	$('#'+code+'_'+index+'_end_hour').append(OfficeHour.optionHours());
	$('#'+code+'_'+index+'_end_min').append(OfficeHour.optionMins());

	return ++index;
}

OfficeHour.optionHours = function() {

	var hour = [];
	for (var i = 0; i < 24; i++) {
		var option = document.createElement('option'); 
		option.value = i;
		option.innerHTML = i;
		hour.push(option);
	};

	return hour;
}

OfficeHour.optionMins = function() {

	var min = [];
	for (var i = 0; i < 60; i++) {
		var option = document.createElement('option'); 
		option.value = i;
		option.innerHTML = i;
		min.push(option);
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

OfficeHour.setLatestValue = function(type,unit,value) {
	if(type == 'start'){
		if(unit == 'hour'){
			OfficeHour.latestStartHour = value;
		}else if(unit == 'min'){
			OfficeHour.latestStartMin = value;
		}
	}else if(type == 'end'){
		if(unit == 'hour'){
			OfficeHour.latestEndHour = value;
		}else if(unit == 'min'){
			OfficeHour.latestEndMin = value;
		}
	}
}

OfficeHour.getLatestValue = function(type,unit) {
	if(type == 'start'){
		if(unit == 'hour'){
			value = OfficeHour.latestStartHour;
		}else if(unit == 'min'){
			value = OfficeHour.latestStartMin;
		}
	}else if(type == 'end'){
		if(unit == 'hour'){
			value = OfficeHour.latestEndHour;
		}else if(unit == 'min'){
			value = OfficeHour.latestEndMin;
		}
	}
	return value;
}