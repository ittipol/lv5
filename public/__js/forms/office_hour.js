class OfficeHour {
	constructor() {
		this.panel = '_office_time';
		this.sameTime = false;
		this.code = null;
		this.index = 1;
		this.days = ['วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์','วันอาทิตย์'],
		this.latestTime = {
			start_hour: 0,
			start_min: 0,
			end_hour: 0,
			end_min: 0
		}
	}

	load(officeHours,sameTime) {

		let _this = this;

		this.init();
		this.bind();

		if (typeof sameTime != 'undefined') {
			this.sameTime = sameTime;
		}

		if (typeof officeHours != 'undefined') {
			let _officeHours = JSON.parse(officeHours);

			let selects = ['_start_hour','_start_min','_end_hour','_end_min'];

			for (let i = 1; i <= Object.keys(_officeHours).length; i++) {

				if(_officeHours[i]['open']){
					// $('#'+this.code+'_'+i+'_open').prop('checked','checked');

					this.latestStartHour = _officeHours[i]['start_time']['hour'];
					this.latestStartMin = _officeHours[i]['start_time']['min'];
					this.latestEndHour = _officeHours[i]['end_time']['hour'];
					this.latestEndMin = _officeHours[i]['end_time']['min'];

					$('#'+this.code+'_'+i+'_start_hour').val(_officeHours[i]['start_time']['hour']);
					$('#'+this.code+'_'+i+'_start_min').val(_officeHours[i]['start_time']['min']);
					$('#'+this.code+'_'+i+'_end_hour').val(_officeHours[i]['end_time']['hour']);
					$('#'+this.code+'_'+i+'_end_min').val(_officeHours[i]['end_time']['min']);
				}else{
					$('#'+this.code+'_'+i+'_open').removeAttr('checked');
					let obj = $('#'+this.code+'_'+i+'_switch');
					this.disabled(obj,obj.parent());
				}

			}
		}

		$('.'+this.code+'-office-switch-btn').each(function(key, value) {
			_this.disabled(value,$(value).parent());
		});

	}

	init() {

		let _this = this;

		let token = new Token();
		this.code = token.generateToken();

		for (let i = 0; i < this.days.length; i++) {
			this.index = this.createSelect(this.days[i],this.index,this.code);
		}

		if($('#office_hour_same_time').is(':checked')){
			_this.sameTime = true;
			_this.setSameTime(this.code);
		}

	}

	bind() {

		let _this = this;

		$('#office_hour_same_time').on('click',function(){
			if($(this).is(':checked')){
				_this.sameTime = true;
				_this.setSameTime(_this.code);
			}else{
				_this.sameTime = false;
			}
		});

		$('.'+this.code+'-office-switch-btn').on('change',function(){
			_this.disabled(this,$(this).parent());
		});

		$('select[id^="'+this.code+'"]').on('change',function(){
			
			let id =$(this).prop('id');
			let parts = id.split('_');

			_this.setLatestTime(parts[2],parts[3],$(this).val());

			if(_this.sameTime){
				_this.setTimes($(this).prop('id'),$(this).val(),_this.code);
			}
		});

	}

	disabled(obj,parent) {

		let _this = this;

		if(!$(obj).find('input[type="checkbox"]').is(':checked')){
			parent.find('select').val(0).prop('disabled','disabled').addClass('disabled');
			parent.find('.office-status').removeClass('active');
		}else{

			parent.find('select').removeAttr('disabled').removeClass('disabled');
			parent.find('.office-status').addClass('active');

			if(this.sameTime){	
				parent.find('select').each(function(key, value) {
					let id = $(this).prop('id');
					let parts = id.split('_');
					$(this).val(_this.getLatestTime(parts[2],parts[3]));
				});
			}
		}

	}

	setSameTime(code) {
		let selects = [code+'_'+'1_start_hour',code+'_'+'1_start_min',code+'_'+'1_end_hour',code+'_'+'1_end_min'];

		for (let i = 0; i < selects.length; i++) {

			let id = $('#'+selects[i]).prop('id');
			let parts = id.split('_');
			let value = this.getLatestTime(parts[2],parts[3]);

			this.setTimes(selects[i],value,code);			
		};
	}

	setTimes(id,value,code) {
		let parts = id.split('_');

		for (let i = 1; i <= 7; i++) {
			if(!$('#'+code+'_'+i+'_'+parts[2]+'_'+parts[3]).prop('disabled')){
				$('#'+code+'_'+i+'_'+parts[2]+'_'+parts[3]).val(value);
			}
		}
	}

	createSelect(day,index,code) {

		let html = '';
		html += '<div id="'+code+'_'+index+'" class="form-row office-hour">';
		html += '<div class="line space-top-bottom-10"></div>';          
		html += '<label>'+day+'</label> ';   
		html += '<label id="'+code+'_'+index+'_switch" class="switch '+code+'-office-switch-btn">';
		html += '<input id="'+code+'_'+index+'_open" type="checkbox" name="OfficeHour[time]['+index+'][open]" value="1" checked>';
		html += '<div class="slider round office-hour"></div>';
		html += '</label>';
		html += '<span>เวลาเปิด</span>';
		html += '<select id="'+code+'_'+index+'_start_hour" name="OfficeHour[time]['+index+'][start_time][hour]"></select>';
		html += '<b> : </b>';
		html += '<select id="'+code+'_'+index+'_start_min" name="OfficeHour[time]['+index+'][start_time][min]"></select>';
		// html += '<b> - </b>';
		html += '<br/><br/>';
		html += '<span>เวลาปิด</span>';
		html += '<select id="'+code+'_'+index+'_end_hour" name="OfficeHour[time]['+index+'][end_time][hour]"></select>';
		html += '<b> : </b>';
		html += '<select id="'+code+'_'+index+'_end_min" name="OfficeHour[time]['+index+'][end_time][min]"></select>';
		// html += '<div id="'+code+'_'+index+'_status" class="office-status active"></div>';
		html += '</div>';

		$('#'+this.panel).append(html);

		$('#'+code+'_'+index+'_start_hour').append(this.optionData(24));
		$('#'+code+'_'+index+'_start_min').append(this.optionData(60));
		$('#'+code+'_'+index+'_end_hour').append(this.optionData(24));
		$('#'+code+'_'+index+'_end_min').append(this.optionData(60));

		return ++index;
	}

	optionData(number) {

		let data = [];
		for (let i = 0; i < number; i++) {
			let option = document.createElement('option'); 
			option.value = i;
			option.innerHTML = i;
			data.push(option);
		};

		return data;
	}

	setLatestTime (type,unit,value) {
	  this.latestTime[type+'_'+unit] = value;
	};

	getLatestTime (type,unit) {
	  return this.latestTime[type+'_'+unit];
	};

}