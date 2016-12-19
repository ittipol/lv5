var Images = {
	id: null,
	code: null,
	panel: '_image_group',
	type: 'images',
	limit: 5,
	index: 0,
	runningNumber: 0,
	imagesPlaced: [],
	filenames: [], 
	defaultImage: '/images/add_images2.svg',
	allowedClick: true
}

Images.load = function(panel,type,limit,imageJson){
	Images.init(panel,type,limit)
	Images.bind();

	if (typeof imageJson != 'undefined') {
		var _images = JSON.parse(imageJson);
		for (var i = 0; i < _images.length; i++) {
			Images.index = Images._createUploader(Images.index,_images[i]);
		}
	}

	Images.index = Images.createUploader(Images.index);
}

Images.init = function(panel,type,limit){
	Images.code = Images.generateCode();
	Images.panel = panel;
	Images.type = type;
	Images.limit = limit;
}

Images.bind = function(){

	$(document).on('change', '.'+Images.code+'-image', function(){
		Images.preview(this);
	});

	$(document).on('click', '.'+Images.code+'-remove-btn', function(){
		Images.removePreview(this);
	});
	
}

Images.preview = function(input){

	if (input.files && input.files[0]) {

		var parent = $(input).parent();
		var CSRF_TOKEN = $('input[name="_token"]').val();    
		var formToken = $('input[name="__token"]').val();
		var proceed = true;

		if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
		  alert("Your browser does not support new File API! Please upgrade.");
			proceed = false;
		}else{
		  var fileSize = input.files[0].size;
		  var mimeType = input.files[0].type;

		  var reader = new FileReader();

		  reader.onload = function (e) {

		  	parent.find('img').css('display','none').attr('src', e.target.result);

		  	if(Images.checkImageType(mimeType) && Images.checkImageSize(fileSize)) {
		  		parent.css('borderColor','#E0E0E0');
		  		parent.find('.error-message').css('display','none').text('');
		  	}else{
		  		parent.css('borderColor','red');
		  		parent.find('.error-message').css('display','block').text('ไม่รองรับรูปภาพนี้');
		  		parent.find('input[type="hidden"]').remove();
		  		parent.find('input').val('');
		  		parent.find('img').fadeIn(1000);
		  	}

		  }

		  reader.readAsDataURL(input.files[0]);

		  if(!Images.checkImageType(mimeType) || !Images.checkImageSize(fileSize)) {
		  	proceed = false;
		  }
		}

		if(proceed) {
			var formData = new FormData();
			formData.append('_token', CSRF_TOKEN);formToken
			formData.append('formToken', formToken);
			formData.append('file', input.files[0]);
			formData.append('type', Images.type);

			Images.uploadImage(parent,input,formData);
		}

	}

}

Images.uploadImage = function(parent,input,data) {

	var id = input.getAttribute('id');

	var request = $.ajax({
    url: "/upload_image",
    type: "POST",
    data: data,
    dataType: 'json',
    contentType: false,
    cache: false,
    processData:false,
    beforeSend: function( xhr ) {
    	$(parent).parent().find('.status').css('width','0%');
    	parent.parent().find('.progress-bar').css('display','block');
    },
    mimeType:"multipart/form-data",
    xhr: function(){
    	//upload Progress
    	var xhr = $.ajaxSettings.xhr();
    	if (xhr.upload) {
    		xhr.upload.addEventListener('progress', function(event) {
    			var percent = 0;
    			var position = event.loaded || event.position;
    			var total = event.total;
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

  		input.remove();

  		parent.addClass('added');
  		parent.find('img').fadeIn(450);
  		parent.find('a').css('display','block');
  		parent.parent().find('.progress-bar').css('display','none');

  		var _input = document.createElement('input');
		  _input.setAttribute('type','hidden');
		  _input.setAttribute('name','filenames['+(Images.runningNumber-1)+']');
		  _input.setAttribute('value',response.filename);
		  parent.append(_input);

  		if(Images.imagesPlaced.indexOf(id) < 0){
  			Images.imagesPlaced.push(id);

  			if(Images.index < Images.limit){
  				Images.index = Images.createUploader(Images.index);
  			}
  		}
  	}
  	
  });

  request.fail(function (jqXHR, textStatus, errorThrown){
    // Log the error to the console
    console.error(
        "The following error occurred: "+
        textStatus, errorThrown
    );
  });

}

Images.removePreview = function(input){

	if(Images.allowedClick){

		Images.allowedClick = false;

		var parent = $(input).parent(); 
		parent.fadeOut(220);  

		var data = {
			'_token': $('input[name="_token"]').val(),
			'formToken': $('input[name="__token"]').val(),
			'filename': parent.find('input[type="hidden"]').val(),
			'type': Images.type
		};

		Images.deleteImage(parent,input,data);

	}
	
}

Images.deleteImage = function(parent,input,data) {
	var request = $.ajax({
	  url: "/delete_image",
	  type: "POST",
	  data: data,
	  dataType: 'json'
	});

	request.done(function (response, textStatus, jqXHR){

		if(response.success){
			--Images.index;

			if(Images.imagesPlaced.length == Images.limit){
				Images.index = Images.createUploader(Images.index);
			}

			// var parent = $(input).parent();
			Images.imagesPlaced.splice(Images.imagesPlaced.indexOf($(parent).find('input').attr('id')),1); 

			parent.parent().remove();
		}
		
	});

	request.fail(function (jqXHR, textStatus, errorThrown){
    // Log the error to the console
    console.error(
        "The following error occurred: "+
        textStatus, errorThrown
    );
  });

  request.always(function () {
  	Images.allowedClick = true;
  });
}

Images.createUploader = function(index){
	
	var html = '';
	html += '<div id="'+Images.code+'_panel_'+Images.runningNumber+'" class="image-panel">';
	html += '<label id="'+Images.code+'_'+Images.runningNumber+'" class="image-label">';
	html += '<input id="'+Images.code+'_image_'+Images.runningNumber+'" class="'+Images.code+'-image" type="file">';
	html +=	'<img id="'+Images.code+'_preview_'+Images.runningNumber+'" class="preview-image" src="'+Images.defaultImage+'">';
	html += '<a id="'+Images.code+'_button_'+Images.runningNumber+'" href="javscript:void(0);" class="'+Images.code+'-remove-btn">×</a>'
	html += '<p class="error-message"></p>';
	html += '</label>';
	html += '<div id="'+Images.code+'_progress+bar_'+Images.runningNumber+'" class="progress-bar"><div class="status"></div></div>'
	html += '</div>';

	++Images.runningNumber;
	$('#'+Images.panel).append(html);

	return ++index;

}

Images._createUploader = function(index,image){

	var html = '';
	html += '<div id="'+Images.code+'_panel_'+Images.runningNumber+'" class="image-panel">';
	html += '<label id="'+Images.code+'_'+Images.runningNumber+'" class="image-label added">';
	html +=	'<img id="'+Images.code+'_preview_'+Images.runningNumber+'" class="preview-image" src="'+image.url+'">';
	html += '<a id="'+Images.code+'_button_'+Images.runningNumber+'" href="javscript:void(0);" class="'+Images.code+'-remove-btn" style="display:block;">×</a>'
	html += '<p class="error-message"></p>';
	html += '<input type="hidden" name="filenames['+index+']" value="'+image.name+'">'
	html += '</label>';
	html += '</div>';

	++Images.runningNumber;
	$('#'+Images.panel).append(html);

	return ++index;

}

Images.generateCode = function() {
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

Images.checkImageType = function(type){
	var allowedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

	var allowed = false;

	for (var i = 0; i < allowedFileTypes.length; i++) {
		if(type == allowedFileTypes[i]){
			allowed = true;
			break;						
		}
	};

	return allowed;
}

Images.checkImageSize = function(size) {
	// 3MB
	var maxSize = 3145728;

	var allowed = false;

	if(size <= maxSize){
		allowed = true;
	}

	return allowed;

}