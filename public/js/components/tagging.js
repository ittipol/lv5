function Tagging () {
	this.tagChipsWidth = 0;
	this.tagList = [];
	this.padding = 22;
	this.runningNumber = 0;
	this.placeholder = 'แท๊ก';
	this.dataName = 'Tagging';
	this.panel = '_tags';
	this.code = null;
}
// Tagging.prototype.
Tagging.prototype.load = function(tagJson){

	this.init();
	this.bind();
	this.crateTagList();
	this.crateInputTagField();

	if (typeof tagJson != 'undefined') {
		var _tags = JSON.parse(tagJson);
		for (var i = 0; i < _tags.length; i++) {
			this.createTagChip(_tags[i]['name']);
		}
	}

}

Tagging.prototype.init = function(){
	this.tagChipsWidth = 0;
	this.code = this.generateCode();
}

Tagging.prototype.bind = function(){}

Tagging.prototype.createHiddenField = function(index,id,tagName) {
	var input = document.createElement('input');
  input.setAttribute('type','hidden');
  input.setAttribute('name',this.dataName+'['+index+']');
  input.setAttribute('id',id+'_name');
  input.setAttribute('value',tagName);
  $('form').append(input);
}

Tagging.prototype.removeHiddenField = function(id) {
	$('#'+id+'_name').remove();
}

Tagging.prototype.crateTagList = function(){
	var span = document.createElement('span');
	span.setAttribute('id',this.code+'_tag_list');
	
	document.getElementById(this.panel).appendChild(span);
}

Tagging.prototype.crateInputTagField = function(){

	var _this = this;

	var input = document.createElement('input');
	input.setAttribute('type','search');
	input.setAttribute('id',this.code+'_tag_input');
	input.setAttribute('tabindex','0');
	input.setAttribute('autocomplete','off');
	input.setAttribute('autocorrect','off');
	input.setAttribute('autocapitalize','off');
	input.setAttribute('spellcheck','false');
	input.setAttribute('role','textbox');
	input.setAttribute('placeholder',this.placeholder);
	input.style.width = $('#'+this.panel).width()+'px';

	input.addEventListener("keydown", function(e){

		if(e.keyCode == 13){
			e.preventDefault();

			if(this.value != ''){
				_this.createTagChip(this.value);
				this.value = '';
			}
			// return false;
		}else if(e.keyCode == 8){

			if(this.value == ''){
				e.preventDefault();

				var obj = document.getElementById(_this.tagList[_this.tagList.length-1]);

				if(obj != null){
					document.getElementById(this.code+'_tag_input').value = $(obj).find('span.tag-name').text();
					document.getElementById(this.code+'_tag_input').select();

					_this.tagChipsWidth -= $(obj).width()+_this.padding; 
					_this.calInputFielsWidth();

					// remove hidden field
					_this.removeHiddenField(_this.tagList[_this.tagList.length-1]);

					// remove tag chip
					$(obj).remove();

					// remove from array
					_this.tagList.splice(_this.tagList.length-1,1);
				}

			}

		}

	}, false);

	$(input).on('blur',function(){
		if(this.value != ''){
			_this.createTagChip(this.value);
			this.value = '';
		}
	});

	document.getElementById(this.panel).appendChild(input);
}

Tagging.prototype.createTagChip = function(tagName){

	var _this = this;

	// var id = 'tag_'+this.generateCode();
	var id = 'tag_'+this.code+'_'+this.runningNumber;
	this.tagList.push(id);

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

		_this.tagList.splice(_this.tagList.indexOf($(this).parent().attr('id')),1);

		_this.tagChipsWidth -= $(this).parent().width()+_this.padding; 
		_this.calInputFielsWidth();

		// 
		$('#'+this.code+'_tag_input').focus();

		// remove hidden field
		_this.removeHiddenField($(this).parent().attr('id'));

		// remove tag chip
		$(this).parent().remove();

	}, false);

	tagChip.appendChild(tagNameElem);
	tagChip.appendChild(tagDelete);
	document.getElementById(this.code+'_tag_list').appendChild(tagChip);

	this.createHiddenField(this.runningNumber++,id,tagName);

	this.tagChipsWidth += $(tagChip).width()+this.padding; 
	this.calInputFielsWidth();
	
}


Tagging.prototype.generateCode = function() {

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

Tagging.prototype.calInputFielsWidth = function(){
	var inputFieldWidth = $('#'+this.panel).width() - (this.tagChipsWidth % $('#'+this.panel).width());

	if(inputFieldWidth > 120){
		$('#'+this.code+'_tag_input').css('width',inputFieldWidth);
		document.getElementById(this.code+'_tag_input').style.width = inputFieldWidth+'px';
	}else{
		document.getElementById(this.code+'_tag_input').style.width = $('#'+this.panel).width()+'px';
	}
}

Tagging.prototype.setPlaceHolder = function(placeholder){
	this.placeholder = placeholder; 
}

Tagging.prototype.setDataName = function(dataName) {
	this.dataName = dataName;
}

Tagging.prototype.setPanel = function(panel) {
	this.panel = panel;
}