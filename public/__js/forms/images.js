class Images {
	constructor(panel,type,limit,style) {
		this.panel = panel;
		this.type = type;
		this.limit = limit;
		this.id = null;
		this.code = null;
		this.index = 0;
		this.runningNumber = 0;
		this.imagesPlaced = [];
		this.filenames = []; 
		this.defaultImage = '/images/common/image.svg';
		this.allowedClick = true;
		this.style = style;
	}

	load(imageJson){

		this.init();
		this.bind();

		if (typeof imageJson != 'undefined') {
			let _images = JSON.parse(imageJson);
			for (let i = 0; i < _images.length; i++) {
				this.imagesPlaced.push(this.index);
				this.index = this._createUploader(this.index,_images[i]);
			}
		}

		if(this.index < this.limit){
			this.index = this.createUploader(this.index);
		}
	}

	init(){
		let token = new Token();
		this.code = token.generateToken();
	}

	bind(){

		let _this = this;

		$(document).on('change', '.'+this.code+'-image', function(){
			_this.preview(this);
		});

		$(document).on('click', '.'+this.code+'-remove-btn', function(){
			_this.removePreview(this);
		});
		
	}

	preview(input){

		if (input.files && input.files[0]) {

			if(typeof $('input[name="__token"]').val() == 'undefined') {
				alert('Error, token not found');
				return false;
			} 

			let _this = this;

			let parent = $(input).parent();
			let CSRF_TOKEN = $('input[name="_token"]').val();    
			let formToken = $('input[name="__token"]').val();
			let proceed = true;

			if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
			  alert("Your browser does not support new File API! Please upgrade.");
				proceed = false;
			}else{
			  let fileSize = input.files[0].size;
			  let mimeType = input.files[0].type;

			  let reader = new FileReader();

			  reader.onload = function (e) {

			  	parent.find('img').css('display','none').attr('src', e.target.result);

			  	if(_this.checkImageType(mimeType) && _this.checkImageSize(fileSize)) {
			  		parent.css('borderColor','#E0E0E0');
			  		parent.find('.error-message').css('display','none').text('');
			  	}else{
			  		parent.css('borderColor','red');
			  		parent.find('.error-message').css('display','block').text('ไม่รองรับรูปภาพนี้');
			  		parent.find('input[type="hidden"]').remove();
			  		parent.find('input').val('');
			  		parent.find('img').css('display','none');
			  	}

			  }

			  reader.readAsDataURL(input.files[0]);

			  if(!this.checkImageType(mimeType) || !this.checkImageSize(fileSize)) {
			  	proceed = false;
			  }
			}

			if(proceed) {
				let formData = new FormData();
				formData.append('_token', CSRF_TOKEN);formToken
				formData.append('formToken', formToken);
				formData.append('file', input.files[0]);
				formData.append('type', this.type);

				this.uploadImage(parent,input,formData);
			}

		}

	}

	uploadImage(parent,input,data) {

		let _this = this;
		
		let id = input.getAttribute('id');

		let request = $.ajax({
	    url: "/upload_image",
	    type: "POST",
	    data: data,
	    dataType: 'json',
	    contentType: false,
	    cache: false,
	    processData:false,
	    beforeSend: function( xhr ) {
	    	input.remove();
	    	$(parent).parent().find('.status').css('width','0%');
	    	parent.parent().find('.progress-bar').css('display','block');
	    },
	    mimeType:"multipart/form-data",
	    xhr: function(){
	    	//upload Progress
	    	let xhr = $.ajaxSettings.xhr();
	    	if (xhr.upload) {
	    		xhr.upload.addEventListener('progress', function(event) {
	    			let percent = 0;
	    			let position = event.loaded || event.position;
	    			let total = event.total;
	    			if (event.lengthComputable) {
	    				percent = Math.ceil(position / total * 100);
	    			}
	    			//update progressbar
	    			parent.parent().find('.status').css('width',percent +'%');
	    		}, true);
	    	}
	    	return xhr;
	    }
	  });

	  request.done(function (response, textStatus, jqXHR){

	  	if(response.success){

	  		parent.addClass('added');
	  		parent.find('img').fadeIn(450);
	  		parent.find('a').css('display','block');
	  		parent.parent().find('.progress-bar').css('display','none');

	  		let _input = document.createElement('input');
			  _input.setAttribute('type','hidden');
			  _input.setAttribute('name','filenames['+(_this.runningNumber-1)+']');
			  _input.setAttribute('value',response.filename);
			  parent.append(_input);

	  		if(_this.imagesPlaced.indexOf(id) < 0){
	  			_this.imagesPlaced.push(id);

	  			if(_this.index < _this.limit){
	  				_this.index = _this.createUploader(_this.index);
	  			}
	  		}
	  	}else{

	  		if(typeof response.message == 'object') {
					const notificationBottom = new NotificationBottom(response.message.title,'',response.message.type);
					notificationBottom.load();
	  		}

	  	}
	  	
	  });

	  request.fail(function (jqXHR, textStatus, errorThrown){

	    console.error(
	        "The following error occurred: "+
	        textStatus, errorThrown
	    );
	  });

	}

	removePreview(input){

		if(typeof $('input[name="__token"]').val() == 'undefined') {
			return false;
		}

		if(this.allowedClick){

			this.allowedClick = false;

			let parent = $(input).parent(); 
			parent.fadeOut(220);  

			let data = {
				'_token': $('input[name="_token"]').val(),
				'formToken': $('input[name="__token"]').val(),
				'filename': parent.find('input[type="hidden"]').val(),
				'type': this.type
			};

			this.deleteImage(parent,input,data);

		}
		
	}

	deleteImage(parent,input,data) {

		let _this = this;

		let request = $.ajax({
		  url: "/delete_image",
		  type: "POST",
		  data: data,
		  dataType: 'json'
		});

		request.done(function (response, textStatus, jqXHR){

			if(response.success){
				--_this.index;

				if(_this.imagesPlaced.length == _this.limit){
					_this.index = _this.createUploader(_this.index);
				}

				_this.imagesPlaced.splice(_this.imagesPlaced.indexOf($(parent).find('input').attr('id')),1); 

				parent.parent().remove();
			}else{
				parent.fadeIn(100); 
				parent.css('borderColor','red');
				parent.find('.error-message').css('display','block').text('เกิดข้อผิดพลาด ไม่สามารถลบรูปภาพได้');
			}
			
		});

		request.fail(function (jqXHR, textStatus, errorThrown){

	    console.error(
	        "The following error occurred: "+
	        textStatus, errorThrown
	    );
	  });

	  request.always(function () {
	  	_this.allowedClick = true;
	  });
	}

	createUploader(index){

		let html = '';
		html += '<div id="'+this.code+'_panel_'+this.runningNumber+'" class="image-panel">';
		html += '<label id="'+this.code+'_'+this.runningNumber+'" class="image-label">';
		html += '<input id="'+this.code+'_image_'+this.runningNumber+'" class="'+this.code+'-image" type="file">';
		html +=	'<img id="'+this.code+'_preview_'+this.runningNumber+'" class="preview-image" src="'+this.defaultImage+'">';
		html += '<a id="'+this.code+'_button_'+this.runningNumber+'" href="javscript:void(0);" class="'+this.code+'-remove-btn">×</a>'
		html += '<p class="error-message"></p>';
		html += '</label>';
		html += '<div id="'+this.code+'_progress+bar_'+this.runningNumber+'" class="progress-bar"><div class="status"></div></div>'
		html += '</div>';

		++this.runningNumber;
		$('#'+this.panel).append(html);

		return ++index;

	}

	_createUploader(index,image){

		let html = '';
		html += '<div id="'+this.code+'_panel_'+this.runningNumber+'" class="image-panel">';
		html += '<label id="'+this.code+'_'+this.runningNumber+'" class="image-label added">';
		html +=	'<img id="'+this.code+'_preview_'+this.runningNumber+'" class="preview-image" src="'+image.url+'">';
		html += '<a id="'+this.code+'_button_'+this.runningNumber+'" href="javscript:void(0);" class="'+this.code+'-remove-btn" style="display:block;">×</a>'
		html += '<p class="error-message"></p>';
		html += '<input type="hidden" name="filenames['+index+']" value="'+image.name+'">'
		html += '</label>';
		html += '</div>';

		++this.runningNumber;
		$('#'+this.panel).append(html);

		return ++index;

	}

	checkImageType(type){
		let allowedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

		let allowed = false;

		for (let i = 0; i < allowedFileTypes.length; i++) {
			if(type == allowedFileTypes[i]){
				allowed = true;
				break;						
			}
		};

		return allowed;
	}

	checkImageSize(size) {
		// 3MB
		let maxSize = 3145728;

		let allowed = false;

		if(size <= maxSize){
			allowed = true;
		}

		return allowed;
	}
}
