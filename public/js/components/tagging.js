var Tagging = {
	tagChipsWidth: 0,
	tagList: [],
	padding: 22,
	runningNumber: 0,
	placeholder: 'แท๊ก',
	dataName: 'Tagging'
}

Tagging.load = function(tagJson){

	Tagging.init();
	Tagging.bind();
	Tagging.crateTagList();
	Tagging.crateInputTagField();

	if (typeof tagJson != 'undefined') {
		var _tags = JSON.parse(tagJson);
		for (var i = 0; i < _tags.length; i++) {
			Tagging.createTagChip(_tags[i]['name']);
		}
	}

}

Tagging.init = function(){
	Tagging.tagChipsWidth = 0;
}

Tagging.bind = function(){
}

Tagging.createHiddenField = function(index,id,tagName) {
	var input = document.createElement('input');
  input.setAttribute('type','hidden');
  input.setAttribute('name',Tagging.dataName+'['+index+']');
  input.setAttribute('id',id+'_name');
  input.setAttribute('value',tagName);
  $('form').append(input);
}

Tagging.removeHiddenField = function(id) {
	$('#'+id+'_name').remove();
}

Tagging.crateTagList = function(){
	var span = document.createElement('span');
	span.setAttribute('id','tag_list');

	document.getElementById('tags').appendChild(span);

}

Tagging.crateInputTagField = function(){
	var input = document.createElement('input');
	input.setAttribute('type','search');
	input.setAttribute('id','tag_input');
	input.setAttribute('tabindex','0');
	input.setAttribute('autocomplete','off');
	input.setAttribute('autocorrect','off');
	input.setAttribute('autocapitalize','off');
	input.setAttribute('spellcheck','false');
	input.setAttribute('role','textbox');
	input.setAttribute('placeholder',Tagging.placeholder);
	input.style.width = $('#tags').width()+'px';

	input.addEventListener("keydown", function(e){

		if(e.keyCode == 13){
			e.preventDefault();

			if(this.value != ''){
				Tagging.createTagChip(this.value);
				this.value = '';
			}
			// return false;
		}else if(e.keyCode == 8){

			if(this.value == ''){
				e.preventDefault();

				var obj = document.getElementById(Tagging.tagList[Tagging.tagList.length-1]);

				if(obj != null){
					document.getElementById('tag_input').value = $(obj).find('span.tag-name').text();
					document.getElementById('tag_input').select();

					Tagging.tagChipsWidth -= $(obj).width()+Tagging.padding; 
					Tagging.calInputFielsWidth();

					// remove hidden field
					Tagging.removeHiddenField(Tagging.tagList[Tagging.tagList.length-1]);

					// remove tag chip
					$(obj).remove();

					// remove from array
					Tagging.tagList.splice(Tagging.tagList.length-1,1);
				}

			}

		}

	}, false);

	$(input).on('blur',function(){
		if(this.value != ''){
			Tagging.createTagChip(this.value);
			this.value = '';
		}
	});

	document.getElementById('tags').appendChild(input);
}

Tagging.createTagChip = function(tagName){

	var id = 'tag_'+Tagging.generateCode();
	Tagging.tagList.push(id);

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

		Tagging.tagList.splice(Tagging.tagList.indexOf($(this).parent().attr('id')),1);

		Tagging.tagChipsWidth -= $(this).parent().width()+Tagging.padding; 
		Tagging.calInputFielsWidth();

		// 
		$('#tag_input').focus();

		// remove hidden field
		Tagging.removeHiddenField($(this).parent().attr('id'));

		// remove tag chip
		$(this).parent().remove();

	}, false);

	tagChip.appendChild(tagNameElem);
	tagChip.appendChild(tagDelete);
	document.getElementById('tag_list').appendChild(tagChip);

	Tagging.createHiddenField(Tagging.runningNumber++,id,tagName);

	Tagging.tagChipsWidth += $(tagChip).width()+Tagging.padding; 
	Tagging.calInputFielsWidth();
	
}


Tagging.generateCode = function() {

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

Tagging.calInputFielsWidth = function(){
	var inputFieldWidth = $('#tags').width() - (Tagging.tagChipsWidth % $('#tags').width());

	if(inputFieldWidth > 120){
		$('#tag_input').css('width',inputFieldWidth);
		document.getElementById('tag_input').style.width = inputFieldWidth+'px';
	}else{
		document.getElementById('tag_input').style.width = $('#tags').width()+'px';
	}
}