var ItemImages = {
	id: null,
	code: null,
	elem: '_item_image_group',
	limit: 10,
	index: 0,
	runningNumber: 0,
	imagesPlaced: [], 
	defaultImage: '/images/add_images2.svg'
}

ItemImages.load = function(){
	ItemImages.code = ItemImages.generateCode();
	ItemImages.index = ItemImages.createUploader(0);
	
	ItemImages.bind();
}

ItemImages.bind = function(){

	$(document).on('change', '.'+ItemImages.code+'-image', function(){
		ItemImages.preview(this);
	});

	$(document).on('click', '.'+ItemImages.code+'-remove-btn', function(){
		ItemImages.removePreview(this);
	});
	
}

ItemImages.preview = function(input){

	var parent = $(input).parent();

	if (input.files && input.files[0]) {

		var reader = new FileReader();

		reader.onload = function (e) {
			parent.find('a').css('display','block');
			parent.find('img').css('display','block').attr('src', e.target.result);

			if(ItemImages.imagesPlaced.indexOf(input.getAttribute('id')) < 0){
				ItemImages.imagesPlaced.push(input.getAttribute('id'));

				if(ItemImages.index < ItemImages.limit){
					ItemImages.index = ItemImages.createUploader(ItemImages.index);
				}
			}

			if(ItemImages.checkImageType(input.files[0]['type']) && ItemImages.checkImageSize(input.files[0]['size'])) {
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

ItemImages.removePreview = function(input){

	--ItemImages.index;

	if(ItemImages.imagesPlaced.length == ItemImages.limit){
		ItemImages.index = ItemImages.createUploader(ItemImages.index);
	}

	var parent = $(input).parent();
	ItemImages.imagesPlaced.splice(ItemImages.imagesPlaced.indexOf($(parent).find('input').attr('id')),1); 

	parent.parent().remove();
	
}

ItemImages.createUploader = function(index){
	
	var html = '';
	html += '<div id="'+ItemImages.code+'_panel_'+ItemImages.runningNumber+'" class="image-panel">';
	html += '<label id="'+ItemImages.code+'_'+ItemImages.runningNumber+'" class="image-label">';
	html += '<input id="'+ItemImages.code+'_image_'+ItemImages.runningNumber+'" class="'+ItemImages.code+'-image" name="item_images['+ItemImages.runningNumber+']" type="file">';
	html +=	'<img id="'+ItemImages.code+'_preview_'+ItemImages.runningNumber+'" class="preview-image" src="'+ItemImages.defaultImage+'">';
	html += '<a id="'+ItemImages.code+'_button_'+ItemImages.runningNumber+'" href="javscript:void(0);" class="'+ItemImages.code+'-remove-btn">×</a>'
	html += '<p class="error-message"></p>';
	html += '</label>';
	html += '<div>';
	html += '<input name="item_name['+ItemImages.runningNumber+']" type="text" placeholder="ชื่อสินค้า" />';
	html += '<input name="item_price['+ItemImages.runningNumber+']" type="text" placeholder="ราคาสินค้า" />';
	html += '</div>';
	html += '</div>';

	++ItemImages.runningNumber;
	$("#"+ItemImages.elem).append(html);

	return ++index;

}

ItemImages.generateCode = function() {
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

ItemImages.checkImageType = function(type){
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

ItemImages.checkImageSize = function(size) {
	// 3MB
	var maxSize = 3145728;

	var accepted = false;

	if(size <= maxSize){
		accepted = true;
	}

	return accepted;

}