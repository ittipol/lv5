var OfficeHour = {
	sameTime: false
}

OfficeHour.load = function() {
	OfficeHour.bind();
}

OfficeHour.bind = function() {

	$('#same_time').on('click',function(){
		if($(this).is(':checked')){
			OfficeHour.sameTime = true;
		}else{
			OfficeHour.sameTime = false;
		}
	});


	$('select[name^="OfficeHour"]').on('change',function(){
		if(OfficeHour.sameTime){

			var id = $(this).prop('id');
			var parts = id.split('_');

			for (var i = 1; i <= 7; i++) {
				$('#'+i+'_'+parts[1]+'_'+parts[2]).val($(this).val());
			}
		}
	});

	$('.office-close-btn').on('click',function(){

		var parent = $(this).parent();

		if($(this).find('input[type="checkbox"]').is(':checked')){
			parent.find('select').prop('disabled','disabled').addClass('disabled');
		}else{
			parent.find('select').removeAttr('disabled').removeClass('disabled');
		}

	});
}