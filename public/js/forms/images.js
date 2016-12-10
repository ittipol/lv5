var Images = {
	id: null,
	code: null,
	elem: '_image_group',
	limit: 5,
	index: 0,
	runningNumber: 0,
	imagesPlaced: [], 
	defaultImage: '/images/add_images2.svg'
}

Images.load = function(){
	Images.code = Images.generateCode();
	Images.index = Images.createUploader(0);
	
	Images.bind();
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

	var parent = $(input).parent();

	if (input.files && input.files[0]) {

		var reader = new FileReader();

		reader.onload = function (e) {
			parent.find('a').css('display','block');
			parent.find('img').css('display','block').attr('src', e.target.result);

			if(Images.imagesPlaced.indexOf(input.getAttribute('id')) < 0){
				Images.imagesPlaced.push(input.getAttribute('id'));

				if(Images.index < Images.limit){
					Images.index = Images.createUploader(Images.index);
				}
			}

			if(Images.checkImageType(input.files[0]['type']) && Images.checkImageSize(input.files[0]['size'])) {
				parent.css('borderColor','#E0E0E0');
				parent.find('.error-message').css('display','none').text('');
			}else{
				parent.css('borderColor','red');
				parent.find('.error-message').css('display','block').text('ไม่รองรับรูปภาพนี้');
				parent.find('input').val('');
			}

		}

		reader.readAsDataURL(input.files[0]);

	}

}

Images.removePreview = function(input){

	--Images.index;

	if(Images.imagesPlaced.length == Images.limit){
		Images.index = Images.createUploader(Images.index);
	}

	var parent = $(input).parent();
	Images.imagesPlaced.splice(Images.imagesPlaced.indexOf($(parent).find('input').attr('id')),1); 

	parent.parent().remove();
	
}

Images.createUploader = function(index){
	
	var html = '';
	html += '<div id="'+Images.code+'_panel_'+Images.runningNumber+'" class="image-panel">';
	html += '<label id="'+Images.code+'_'+Images.runningNumber+'" class="image-label">';
	html += '<input id="'+Images.code+'_image_'+Images.runningNumber+'" class="'+Images.code+'-image" name="images['+Images.runningNumber+']" type="file">';
	html +=	'<img id="'+Images.code+'_preview_'+Images.runningNumber+'" class="preview-image" src="'+Images.defaultImage+'">';
	html += '<a id="'+Images.code+'_button_'+Images.runningNumber+'" href="javscript:void(0);" class="'+Images.code+'-remove-btn">×</a>'
	html += '<p class="error-message"></p>';
	html += '</label>';
	html += '</div>';

	++Images.runningNumber;
	$('#'+Images.elem).append(html);

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
	var acceptedType = ['image/jpg','image/jpeg','image/png'];

	var accepted = false;

	for (var i = 0; i < acceptedType.length; i++) {
		if(type == acceptedType[i]){
			accepted = true;
			break;						
		}
	};

	return accepted;
}

Images.checkImageSize = function(size) {
	// 3MB
	var maxSize = 3145728;

	var accepted = false;

	if(size <= maxSize){
		accepted = true;
	}

	return accepted;

}