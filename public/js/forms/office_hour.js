var OfficeHour = {
	sameTime: false
}

OfficeHour.load = function() {
	OfficeHour.init();
	OfficeHour.bind();
}

OfficeHour.init = function() {
	$('.office-switch-btn').each(function(key, value) {
		OfficeHour.disabled(value,$(value).parent());
	});
}

OfficeHour.bind = function() {

	$('#same_time').on('click',function(){alert('xxx');
		if($(this).is(':checked')){
			OfficeHour.sameTime = true;

			var selects = ['1_start_hour','1_start_min','1_end_hour','1_end_min'];

			for (var i = 0; i < selects.length; i++) {	
				OfficeHour.setTime(selects[i],$('#'+selects[i]).val());			
			};

		}else{
			OfficeHour.sameTime = false;
		}
	});


	$('select[name^="OfficeHour"]').on('change',function(){
		if(OfficeHour.sameTime){
			OfficeHour.setTime($(this).prop('id'),$(this).val());
		}
	});

	$('.office-switch-btn').on('change',function(){
		OfficeHour.disabled(this,$(this).parent());
	});

}

OfficeHour.disabled = function(obj,parent) {
	if(!$(obj).find('input[type="checkbox"]').is(':checked')){
		parent.find('select').prop('disabled','disabled').addClass('disabled');
		parent.find('.office-status').removeClass('active');
	}else{
		parent.find('select').removeAttr('disabled').removeClass('disabled');
		parent.find('.office-status').addClass('active');
	}
}

OfficeHour.setTime = function(id,value) {
	var parts = id.split('_');

	for (var i = 1; i <= 7; i++) {
		$('#'+i+'_'+parts[1]+'_'+parts[2]).val(value);
	}
}