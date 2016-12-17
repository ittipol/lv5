var Tag = {
	tagChipsWidth: 0,
	tagList: [],
	padding: 22,
	runningNumber: 0,
	placeholder: 'แท๊ก',
	dataName: 'Tag'
}

Tag.load = function(tagJson){

	Tag.init();
	Tag.bind();
	Tag.crateTagList();
	Tag.crateInputTagField();

	if (typeof tagJson != 'undefined') {
		var _tags = JSON.parse(tagJson);
		for (var i = 0; i < _tags.length; i++) {
			Tag.createTagChip(_tags[i]['name']);
		}
	}

}

Tag.init = function(){
	Tag.tagChipsWidth = 0;
}

Tag.bind = function(){
}

Tag.createHiddenField = function(index,id,tagName) {
	var input = document.createElement('input');
  input.setAttribute('type','hidden');
  input.setAttribute('name',Tag.dataName+'['+index+']');
  input.setAttribute('id',id+'_name');
  input.setAttribute('value',tagName);
  $('form').append(input);
}

Tag.removeHiddenField = function(id) {
	$('#'+id+'_name').remove();
}

Tag.crateTagList = function(){
	var span = document.createElement('span');
	span.setAttribute('id','tag_list');

	document.getElementById('tags').appendChild(span);

}

Tag.crateInputTagField = function(){
	var input = document.createElement('input');
	input.setAttribute('type','search');
	input.setAttribute('id','tag_input');
	input.setAttribute('tabindex','0');
	input.setAttribute('autocomplete','off');
	input.setAttribute('autocorrect','off');
	input.setAttribute('autocapitalize','off');
	input.setAttribute('spellcheck','false');
	input.setAttribute('role','textbox');
	input.setAttribute('placeholder',Tag.placeholder);
	input.style.width = $('#tags').width()+'px';

	input.addEventListener("keydown", function(e){

		if(e.keyCode == 13){
			e.preventDefault();

			if(this.value != ''){
				Tag.createTagChip(this.value);
				this.value = '';
			}
			// return false;
		}else if(e.keyCode == 8){

			if(this.value == ''){
				e.preventDefault();

				var obj = document.getElementById(Tag.tagList[Tag.tagList.length-1]);

				if(obj != null){
					document.getElementById('tag_input').value = $(obj).find('span.tag-name').text();
					document.getElementById('tag_input').select();

					Tag.tagChipsWidth -= $(obj).width()+Tag.padding; 
					Tag.calInputFielsWidth();

					// remove hidden field
					Tag.removeHiddenField(Tag.tagList[Tag.tagList.length-1]);

					// remove tag chip
					$(obj).remove();

					// remove from array
					Tag.tagList.splice(Tag.tagList.length-1,1);
				}

			}

		}

	}, false);

	$(input).on('blur',function(){
		if(this.value != ''){
			Tag.createTagChip(this.value);
			this.value = '';
		}
	});

	document.getElementById('tags').appendChild(input);
}

Tag.createTagChip = function(tagName){

	var id = 'tag_'+Tag.generateCode();
	Tag.tagList.push(id);

	var tagChip = document.createElement('span');
	tagChip.setAttribute('class','tag-chip');
	tagChip.setAttribute('id',id);

	var tagNameElem = document.createElement('span');
	tagNameElem.setAttribute('class','tag-name');
	tagNameElem.innerHTML = tagName;

	var tagDelete = document.createElement('span');
	tagDelete.setAttribute('class','tag-delete-chip');
	tagDelete.innerHTML = '×';

	tagDelete.addEventListener("click", function(e){

		Tag.tagList.splice(Tag.tagList.indexOf($(this).parent().attr('id')),1);

		Tag.tagChipsWidth -= $(this).parent().width()+Tag.padding; 
		Tag.calInputFielsWidth();

		// 
		$('#tag_input').focus();

		// remove hidden field
		Tag.removeHiddenField($(this).parent().attr('id'));

		// remove tag chip
		$(this).parent().remove();

	}, false);

	tagChip.appendChild(tagNameElem);
	tagChip.appendChild(tagDelete);
	document.getElementById('tag_list').appendChild(tagChip);

	Tag.createHiddenField(Tag.runningNumber++,id,tagName);

	Tag.tagChipsWidth += $(tagChip).width()+Tag.padding; 
	Tag.calInputFielsWidth();
	
}


Tag.generateCode = function() {

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

Tag.calInputFielsWidth = function(){
	var inputFieldWidth = $('#tags').width() - (Tag.tagChipsWidth % $('#tags').width());

	if(inputFieldWidth > 120){
		$('#tag_input').css('width',inputFieldWidth);
		document.getElementById('tag_input').style.width = inputFieldWidth+'px';
	}else{
		document.getElementById('tag_input').style.width = $('#tags').width()+'px';
	}
}